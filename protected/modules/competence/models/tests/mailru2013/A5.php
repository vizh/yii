<?php
namespace competence\models\tests\mailru2013;

class A5 extends \competence\models\Question
{

  public $values = [
    1 => 'Печатные СМИ',
    4 => 'Онлайн СМИ (<em>интернет-издания или интернет-СМИ</em>: <strong>Газета.Ru</strong>, <strong>Lenta.ru</strong>, <strong>Slon.ru</strong>, и т.п.)',
    5 => 'Радио',
    6 => 'Телевидение',
    7 => 'Социальные сети (<strong>Facebook</strong>, <strong>Одноклассники</strong>, <strong>ВКонтакте</strong> и т.п.)',
    8 => 'Социальные СМИ (<strong>Хабрахабр</strong>, <strong>Roem.ru</strong>, <strong>Цукерберг позвонит</strong>)',
    10 => 'Другое'
  ];

  public function rules()
  {
    return [
      ['value', 'checkAllValidator']
    ];
  }

  public function checkAllValidator($attribute, $params)
  {
    $fullData = $this->getFullData();
    $base = new A4($this->test);
    $baseData = $fullData[get_class($base)];
    foreach ($baseData['value'] as $key)
    {
      if (empty($this->value[$key]))
      {
        $this->addError('value', 'Необходимо указать источники информации для каждого из указанных людей.');
        return false;
      }
    }
    return true;
  }


  /**
   * @return \competence\models\Question
   */
  public function getNext()
  {
    return new A6($this->test);
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    return new A4($this->test);
  }
}