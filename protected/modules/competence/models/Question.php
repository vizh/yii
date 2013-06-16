<?php
namespace competence\models;

abstract class Question extends \CFormModel
{
  /** @var Test */
  protected $test;

  public function __construct($test, $scenario = '')
  {
    parent::__construct($scenario);
    $this->test = $test;
  }

  /**
   * @return Test
   */
  public function getTest()
  {
    return $this->test;
  }

  public $value;

  /**
   * @var int - время начала ответа на текущий вопрос
   */
  public $_t;

  public function init()
  {
    $this->_t = time();
  }

  /**
   * @return string|null
   */
  protected function getDefinedViewPath()
  {
    return null;
  }

  private function getGeneratedViewPath()
  {
    $className = get_class($this);
    $className = substr($className, strrpos($className, '\\')+1);
    return "competence.views.tests.".$this->test->Code.".".strtolower($className);
  }

  /**
   * @return string
   */
  public final function getViewPath()
  {
    $definedPath = $this->getDefinedViewPath();
    return $definedPath !== null ? $definedPath : $this->getGeneratedViewPath();
  }

  /**
   * @return bool
   */
  public function parse()
  {
    if ($this->validate())
    {
      $questionData = $this->getQuestionData();
      $key = get_class($this);

      $deltaTime = time() - $this->_t;
      $deltaTime = $deltaTime > 0 ? $deltaTime : 3600;

      $fullData = $this->getFullData();
      if (isset($fullData[$key]))
      {
        $oldDeltaTime = $fullData[$key]['DeltaTime'];
        $deltaTime += $oldDeltaTime;
      }
      $questionData['DeltaTime'] = $deltaTime;
      $fullData[$key] = $questionData;
      $this->setFullData($fullData);

      return true;
    }
    return false;
  }

  /**
   * @return array
   */
  protected function getQuestionData()
  {
    return ['value' => $this->value];
  }

  /**
   * @return string
   */
  public function getQuestionTitle()
  {
    return '';
  }

  /**
   * @return \competence\models\Question
   */
  public abstract function getNext();

  /**
   * @return \competence\models\Question
   */
  public abstract function getPrev();


  public function getFullData()
  {
    return \Yii::app()->getSession()->get('competence-'.$this->test->Code);
  }

  public function setFullData($data)
  {
    \Yii::app()->getSession()->add('competence-'.$this->test->Code, $data);
  }

  public function clearFullData()
  {
    \Yii::app()->getSession()->remove('competence-'.$this->test->Code);
  }

  /**
   * @param string[] $keys
   */
  public function clearFullDataPart($keys)
  {
    $data = $this->getFullData();
    foreach ($keys as $key)
    {
      if (isset($data[$key]))
      {
        unset($data[$key]);
      }
    }
    $this->setFullData($data);
  }

  /*public static function GetPercent($className)
  {
    $percents = array(
      'competence\models\questions\s\S1' => null,
      'competence\models\questions\s\S2' => null,
      'competence\models\questions\e\E1' => 9,
      'competence\models\questions\e\E1_1' => 12,
      'competence\models\questions\e\E2' => 15,
      'competence\models\questions\e\E3' => 18,
      'competence\models\questions\e\E4' => 21,
      'competence\models\questions\e\E5' => 25,
      'competence\models\questions\a\A1' => 30,
      'competence\models\questions\a\A2' => 32,
      'competence\models\questions\a\A3' => 35,
      'competence\models\questions\a\A4' => 38,
      'competence\models\questions\a\A5' => 40,
      'competence\models\questions\a\A6' => 43,
      'competence\models\questions\a\A6_1' => 46,
      'competence\models\questions\a\A7' => 50,
      'competence\models\questions\a\A8' => 53,
      'competence\models\questions\a\A9' => 56,
      'competence\models\questions\a\A10' => 60,
      'competence\models\questions\a\A10_1' => 65,
      'competence\models\questions\s\S5' => 70,
      'competence\models\questions\s\S6' => 73,
      'competence\models\questions\s\S7' => 75,
      'competence\models\questions\s\S3' => 79,
      'competence\models\questions\s\S3_1' => 79,
      'competence\models\questions\c\C1' => 82,
      'competence\models\questions\c\C2' => 85,
      'competence\models\questions\c\C3' => 89,
      'competence\models\questions\c\C4' => 92,
      'competence\models\questions\c\C5' => 95,
      'competence\models\questions\c\C6' => 97,
    );
    return array_key_exists($className, $percents) ? $percents[$className] : '???';
  }*/

  protected function rotate($key, $values)
  {
    $key = 'competence-rotate-' . $this->test->Code . $key;
    $rotation = \Yii::app()->getSession()->get($key);
    if ($rotation === null)
    {
      $rotation = array_keys($values);
      shuffle($rotation);
      \Yii::app()->getSession()->add($key, $rotation);
    }

    $result = array();
    foreach ($rotation as $rKey)
    {
      $result[$rKey] = $values[$rKey];
    }
    return $result;
  }

}