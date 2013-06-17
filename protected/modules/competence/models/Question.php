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