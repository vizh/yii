<?php
namespace competence\models\test\mailru2014_prof;

use competence\models\Result;

class A6_1 extends \competence\models\form\Base {

  protected function getBaseQuestionCode()
  {
    return 'A6';
  }

  protected $options;
  public function getOptions()
  {
    if ($this->options == null)
    {
      /** @var A6 $form */
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

  public $values = [
    1 => 'Печатные СМИ',
    4 => 'Онлайн СМИ (<em>интернет-издания или интернет-СМИ</em>: <strong>Газета.Ru</strong>, <strong>Lenta.ru</strong>, <strong>Slon.ru</strong>, и т.п.)',
    5 => 'Радио',
    6 => 'Телевидение',
    7 => 'Социальные сети (<strong>Facebook</strong>, <strong>Одноклассники</strong>, <strong>ВКонтакте</strong> и т.п.)',
    8 => 'Социальные СМИ (<strong>Хабрахабр</strong>, <strong>Roem.ru</strong>, <strong>Цукерберг позвонит</strong>)',
    10 => 'Другое'
  ];

  public function getE1Result()
  {
    $e1 = \competence\models\Question::model()->byTestId($this->question->TestId)->byCode('E1')->find();
    $e1->setTest($this->question->getTest());
    return $e1->getResult();
  }

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
        $this->addError('value', 'Необходимо указать источники информации для каждой из указанных компаний.');
        return false;
      }
    }
    return true;
  }

    protected function getInternalExportValueTitles()
    {
        $titles = [
            1 => 'Яндекс',
            2 => 'Mail.Ru Group',
            3 => 'Google Russia',
            4 => 'ВКонтакте',
            5 => 'Rambler Media Group',
            6 => 'Google Global',
            7 => 'Facebook',
            8 => 'Microsoft',
            9 => 'Kaspersky',
            10 => 'Parallels',
            11 => 'РБК',
            12 => 'Одноклассники'
        ];
        return array_values($titles);
    }

    protected function getInternalExportData(Result $result)
    {
        $titles = [
            1 => 'Яндекс',
            2 => 'Mail.Ru Group',
            3 => 'Google Russia',
            4 => 'ВКонтакте',
            5 => 'Rambler Media Group',
            6 => 'Google Global',
            7 => 'Facebook',
            8 => 'Microsoft',
            9 => 'Kaspersky',
            10 => 'Parallels',
            11 => 'РБК',
            12 => 'Одноклассники'
        ];
        $keys = array_keys($titles);
        $questionData = $result->getQuestionResult($this->question);
        $data = [];
        foreach ($keys as $key) {
            $data[] = isset($questionData['value'][$key]) ? implode(',', $questionData['value'][$key]) : '';
        }
        return $data;
    }
}
