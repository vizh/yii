<?php
namespace competence\models;

/**
 * Class Test
 * @package competence\models
 *
 * @property int $Id
 * @property string $Code
 * @property string $Title
 * @property bool $Enable
 * @property bool $Test
 * @property string $Info
 * @property string $StartButtonText
 * @property bool $Multiple
 * @property string $EndTime
 * @property string $AfterEndText
 *
 *
 * @method \competence\models\Test find($condition='',$params=array())
 * @method \competence\models\Test findByPk($pk,$condition='',$params=array())
 * @method \competence\models\Test[] findAll($condition='',$params=array())
 */
class Test extends \CActiveRecord
{
  /**
   * @param string $className
   * @return Test
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'CompetenceTest';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return [];
  }

  /** @var \user\models\User */
  protected $user = null;

  /**
   * @param \user\models\User $user
   */
  public function setUser(\user\models\User $user)
  {
    $this->user = $user;
  }

  protected $result = null;

  /**
   * @return Result|null
   * @throws \application\components\Exception
   */
  public function getResult()
  {
    if ($this->result === null)
    {
      if ($this->user === null)
        throw new \application\components\Exception('Для доступа к результату, необходимо сначала задать пользователя.');
      $this->result = Result::model()->byTestId($this->Id)->byUserId($this->user->Id)->byFinished(false)->find();
      if ($this->result === null)
      {
        $this->result = new Result();
        $this->result->TestId = $this->Id;
        $this->result->UserId = $this->user->Id;
        $this->result->setDataByResult([]);
        $this->result->save();
      }
    }
    return $this->result;
  }

  protected $firstQuestion = null;
  /**
   * @return Question
   */
  public function getFirstQuestion()
  {
    if ($this->firstQuestion === null)
    {
      $this->firstQuestion = \competence\models\Question::model()->byFirst()->byTestId($this->Id)->find();
      $this->firstQuestion->Test = $this;
    }
    return $this->firstQuestion;
  }

  public function getEndView()
  {
    $path = 'competence.views.tests.'.$this->Code;
    if (file_exists(\Yii::getPathOfAlias($path).DIRECTORY_SEPARATOR.'end.php'))
    {
      return $path . '.end';
    }
    return 'end';
  }

  public function saveResult()
  {
    $result = $this->getResult();
    $result->Finished = true;
    $result->save();
  }
}