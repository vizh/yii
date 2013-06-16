<?php
namespace competence\models\tests\mailru2013;

class S3_1 extends \competence\models\Question
{
  public $other;

  public $values = [
    1 => 'Журналистика',
    2 => 'Блоггер-сфера',
    3 => 'Финансы',
    5 => 'Консалтинг/аналитика',
    6 => 'Media',
    7 => 'Образование',
    8 => 'Рекрутинг и HR',
    9 => 'Государственная служба',
    98 => 'Другое (укажите, что именно)',
    99 => 'Ничего из перечисленного'
  ];

  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Выберите один ответ из списка'],
      ['value', 'otherSelectionValidator']
    ];
  }

  public function otherSelectionValidator($attribute, $params)
  {
    if ($this->value == 98 && strlen(trim($this->other)) == 0)
    {
      $this->addError('Other', 'При выборе варианта "Другое" необходимо вписать свой вариант СМИ');
      return false;
    }
    return true;
  }

  protected function getQuestionData()
  {
    return ['value' => $this->value, 'other' => $this->other];
  }

  /**
   * @return \competence\models\Question
   */
  public function getNext()
  {
    return new C1($this->test);
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    $fullData = $this->getFullData();
    $s5Data = $fullData[get_class(new S5($this->test))];
    if (in_array($s5Data['value'], array(1, 2, 3)))
    {
      return new S7($this->test);
    }
    else
    {
      return new S6($this->test);
    }
  }
}