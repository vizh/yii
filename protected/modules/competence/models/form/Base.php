<?php
namespace competence\models\form;

abstract class Base extends \CFormModel
{
  /** @var \competence\models\Question */
  protected $question;

  public function __construct($question, $scenario = '')
  {
    parent::__construct($scenario);
    $this->question = $question;
  }

  protected $baseQuestion = null;

  protected function getBaseQuestionCode()
  {
    return null;
  }

  /**
   * @return \competence\models\Question|null
   */
  public function getBaseQuestion()
  {
    if ($this->baseQuestion == null && $this->getBaseQuestionCode() != null)
    {
      $this->baseQuestion = \competence\models\Question::model()
          ->byTestId($this->question->TestId)->byCode($this->getBaseQuestionCode())->find();
      if ($this->baseQuestion != null)
      {
        $this->baseQuestion->setTest($this->question->getTest());
      }
    }
    return $this->baseQuestion;
  }

  public function getQuestionByCode($code)
  {
    $question = \competence\models\Question::model()->byTestId($this->question->TestId)->byCode($code)->find();
    if ($question != null)
    {
      $question->setTest($this->question->getTest());
    }
    return $question;
  }

  /**
   * @return array
   */
  protected function getFormAttributeNames()
  {
    return [];
  }

  public function __get($name)
  {
    if (in_array($name, $this->getFormAttributeNames()))
    {
      $formData = $this->question->getFormData();
      return isset($formData[$name]) ? $formData[$name] : null;
    }
    return parent::__get($name);
  }

  public function __set($name, $value)
  {
    if (in_array($name, $this->getFormAttributeNames()))
    {
      $formData = $this->question->getFormData();
      $formData[$name] = $value;
      $this->question->setFormData($formData);
    }
    else
      parent::__set($name, $value);
  }

  public function __isset($name)
  {
    if (in_array($name, $this->getFormAttributeNames()))
    {
      $formData = $this->question->getFormData();
      return isset($formData[$name]);
    }
    return parent::__isset($name);
  }

  public function __unset($name)
  {
    if (in_array($name, $this->getFormAttributeNames()))
    {
      $formData = $this->question->getFormData();
      if (isset($formData[$name]))
      {
        unset($formData[$name]);
        $this->question->setFormData($formData);
      }
      return;
    }
    else
      parent::__unset($name);
  }


  /**
   * @return \competence\models\Question
   */
  public function getQuestion()
  {
    return $this->question;
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
    return "competence.views.test.".$this->question->Test->Code.".".strtolower($className);
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
  public final function process($alwaysSave = false)
  {
    $valid = $this->validate();
    if ($valid || $alwaysSave)
    {
      $result = $this->question->Test->getResult();
      $oldData = $result->getQuestionResult($this->question);
      $data = $this->getFormData();

      $deltaTime = max(0, time() - $this->_t);
      $data['DeltaTime'] = isset($oldData['DeltaTime']) ? $oldData['DeltaTime'] + $deltaTime : $deltaTime;

      $result->setQuestionResult($this->question, $data);
      $result->save();
    }
    return $valid;
  }

  /**
   * @return array
   */
  protected function getFormData()
  {
    return ['value' => $this->value];
  }

  /**
   * @throws \application\components\Exception
   * @return \competence\models\Question
   */
  public function getNext()
  {
    if ($this->question->Last)
      return null;
    if ($this->question->NextQuestionId !== null)
    {
      return $this->question->Next;
    }
    throw new \application\components\Exception('Необходимо задать Id следующего вопроса или переопределить метод getNext()');
  }

  /**
   * @throws \application\components\Exception
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    if ($this->question->First)
      return null;
    if ($this->question->PrevQuestionId !== null)
    {
      return $this->question->Prev;
    }
    throw new \application\components\Exception('Необходимо задать Id предыдущего вопроса или переопределить метод getPrev()');
  }

  /**
   * @param string[] $keys
   */
  public function clearPartOfResult($keys)
  {
    $result = $this->question->Test->getResult();
    $data = $result->getResultByData();
    foreach ($keys as $key)
    {
      if (isset($data[$key]))
      {
        unset($data[$key]);
      }
    }
    $result->setDataByResult($data);
    $result->save();
  }

  protected function rotate($key, $values)
  {
    $rotationKey = 'competence-rotate-' . $this->question->Test->Code;
    $rotation = \Yii::app()->getSession()->get($rotationKey, []);
    if (!isset($rotation[$key]))
    {
      $rotationValues = array_keys($values);
      shuffle($rotationValues);
      $rotation[$key] = $rotationValues;
      \Yii::app()->getSession()->add($rotationKey, $rotation);
    }

    $result = [];
    foreach ($rotation[$key] as $rKey)
    {
      $result[$rKey] = $values[$rKey];
    }
    return $result;
  }

  public function clearResult()
  {
    $result = $this->question->Test->getResult();
    $result->setDataByResult([]);
    $result->save();
  }

  public function clearRotation()
  {
    \Yii::app()->getSession()->remove('competence-rotate-'.$this->question->Test->Code);
  }

  public function getNumber()
  {
    return null;
  }

  public function getPercent()
  {
    if ($this->getNumber() != null)
    {
      $path = \Yii::getPathOfAlias('competence.models.test.'.$this->question->Test->Code);
      $questionFiles = scandir($path);
      $count = 0;
      foreach ($questionFiles as $file)
      {
        $count += stripos($file, '.php') !== false ? 1 : 0;
      }
      return floor($this->getNumber() * 100 / $count);
    }
    return null;
  }

  public function getAdminView()
  {
    return null;
  }

  public function processAdminPanel()
  {
    $request = \Yii::app()->getRequest();
    $params = $request->getParam(get_class($this->question));
    if (!empty($params['Title']))
    {
      $this->question->Title = $params['Title'];
    }
    else
    {
      $this->question->addError('Title', 'Поле "Текст вопроса" не может быть пустым');
    }
    $this->question->SubTitle = $params['SubTitle'];
    $this->question->BeforeTitleText = $params['BeforeTitleText'];
    $this->question->AfterTitleText = $params['AfterTitleText'];
    $this->question->AfterQuestionText = $params['AfterQuestionText'];
  }
}