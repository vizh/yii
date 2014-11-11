<?php
namespace competence\models\test\mailru2014_prof;

class A5 extends \competence\models\form\Base {

  protected function getBaseQuestionCode()
  {
    return 'A4';
  }

  protected $options = null;
  public function getOptions()
  {
    if ($this->options == null)
    {
      /** @var A4 $form */
      $form = $this->getBaseQuestion()->getForm();
      $result = $this->getBaseQuestion()->getResult();
      if ($result !== null)
      {
        $this->options = [];
        foreach ($form->getOptions() as $key => $value)
        {
          if (in_array($key, $result['value']))
          {
            $this->options[$key] = $value;
          }
        }
      }
    }
    return $this->options;
  }

  public function getE1Result()
  {
    $e1 = \competence\models\Question::model()->byTestId($this->question->TestId)->byCode('E1')->find();
    $e1->setTest($this->question->getTest());
    return $e1->getResult();
  }

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
    foreach ($this->getOptions() as $key => $value)
    {
      if (empty($this->value[$key]))
      {
        $this->addError('value', 'Необходимо указать источники информации для каждого из указанных людей.');
        return false;
      }
    }
    return true;
  }
}
