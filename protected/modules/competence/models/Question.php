<?php
namespace competence\models;

/**
 * Class Question
 * @package competence\models
 *
 * @property int $Id
 * @property int $TestId
 * @property string $TypeId
 * @property string $Data
 * @property int $PrevQuestionId
 * @property int $NextQuestionId
 * @property string $Code
 * @property string $Title
 * @property string $SubTitle
 * @property boolean $First
 * @property boolean $Last
 * @property int $Sort
 * @property string $BeforeTitleText
 * @property string $AfterTitleText
 * @property string $AfterQuestionText
 *
 * @property QuestionType $Type
 * @property Question $Prev
 * @property Question $Next
 *
 * @property Test $Test
 *
 *
 * @method \competence\models\Question find($condition='',$params=array())
 * @method \competence\models\Question findByPk($pk,$condition='',$params=array())
 * @method \competence\models\Question[] findAll($condition='',$params=array())
 */
class Question extends \CActiveRecord
{
  /**
   * @param string $className
   * @return Question
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'CompetenceQuestion';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return [
      'Type' => [self::BELONGS_TO, '\competence\models\QuestionType', 'TypeId'],
      'Prev' => [self::BELONGS_TO, '\competence\models\Question', 'PrevQuestionId'],
      'Next' => [self::BELONGS_TO, '\competence\models\Question', 'NextQuestionId']
    ];
  }

  /**
   * @param bool $first
   * @param bool $useAnd
   * @return $this
   */
  public function byFirst($first = true, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = (!$first ? 'NOT ' : '') . '"t"."First"';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param int $testId
   * @param bool $useAnd
   * @return $this
   */
  public function byTestId($testId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."TestId" = :TestId';
    $criteria->params = ['TestId' => $testId];
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param string $code
   * @param bool $useAnd
   * @return $this
   */
  public function byCode($code, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."Code" = :Code';
    $criteria->params = ['Code' => $code];
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  private $form = null;

  /**
   * @return \competence\models\form\Base
   */
  public function getForm()
  {
    if ($this->form === null)
    {
      $className = "\\competence\\models\\test\\" . $this->Test->Code . "\\" . $this->Code;
      $this->form = new $className($this);
    }
    return $this->form;
  }

  protected $formData = null;

  /**
   * @return array|null
   */
  public function getFormData()
  {
    if ($this->formData === null)
    {
      $this->formData = $this->Data !== null ? unserialize(base64_decode($this->Data)) : [];
    }
    return $this->formData;
  }

  /**
   * @param array $data
   */
  public function setFormData($data)
  {
    $this->formData = $data;
    $this->Data = base64_encode(serialize($data));
  }

  protected $test;

  public function setTest(Test $test)
  {
    if ($test->Id != $this->TestId)
      throw new \application\components\Exception('Тест не соответствует данному вопросу');
    $this->test = $test;
  }

  /**
   * @throws \application\components\Exception
   * @return Test
   */
  public function getTest()
  {
    if ($this->test === null)
      throw new \application\components\Exception('Для вопроса не определен тест');
    return $this->test;
  }

  /**
   * @return array
   */
  public function getResult()
  {
    try
    {
      return $this->getTest()->getResult()->getQuestionResult($this);
    }
    catch (\application\components\Exception $e)
    {
      return null;
    }
  }

  protected function getFormPath()
  {
    return \Yii::getPathOfAlias('competence.models.test.'.$this->Test->Code.'.'.$this->Code).'.php';
  }

  protected function beforeSave()
  {
    if ($this->getIsNewRecord())
    {
      $dataFile = \Yii::app()->getController()->renderPartial('competence.views.form.template', ['question' => $this, 'test' => $this->Test], true);
      file_put_contents($this->getFormPath(), $dataFile);
    }
    return parent::beforeSave();
  }

  public function attributeLabels()
  {
    return [
      'Title' => \Yii::t('app', 'Вопрос'),
      'SubTitle' => \Yii::t('app', 'Дополнительный текст к вопросу'),
      'BeforeTitleText' => \Yii::t('app', 'Текст перед вопросом'),
      'AfterTitleText' => \Yii::t('app', 'Текст после вопроса'),
      'AfterQuestionText' => \Yii::t('app', 'Текст после вариантов ответов'),
    ];
  }

}