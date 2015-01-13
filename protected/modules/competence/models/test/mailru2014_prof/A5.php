<?php
namespace competence\models\test\mailru2014_prof;

use competence\models\Result;

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

    protected function getInternalExportValueTitles()
    {
        $titles = [
            39 => '<strong>Волож</strong> (<em>Яндекс</em>)',
            40 => '<strong>Гришин</strong> (<em>Mail.Ru&nbsp;Group</em>)',
            41 => '<strong>Дуров</strong> (<em>ex ВКонтакте</em>)',
            403 => '<strong>Рогозов</strong> (<em>ВКонтакте</em>)',
            404 => '<strong>Добродеев</strong> (<em>ВКонтакте, Mail.Ru Group</em>)',
            405 => '<strong>Сергеев</strong> (<em>Mail.Ru Group</em>)',
            42 => '<strong>Молибог</strong> (<em>РБК</em>)',
            43 => '<strong>Пейдж</strong> (<em>Google&nbsp;Global</em>)',
            44 => '<strong>Цукерберг</strong> (<em>Facebook</em>)',
            45 => '<strong>Балмер</strong> (<em>ex Microsoft</em>)',
            406 => '<strong>Наделла</strong> (<em>Microsoft</em>)',
            46 => '<strong>Касперский</strong> (<em>Касперский</em>)',
            47 => '<strong>Белоусов</strong> (<em>Parallels</em>)',
            408 => '<strong>Соловьева</strong> (<em>Google Россия</em>)',
            48 => '<strong>Долгов</strong> (<em>eBay</em>)',
            407 => '<strong>Федчин</strong> (<em>Одноклассники</em>)',
            400 => '<strong>Широков</strong> (<em>Mail.Ru Group, ex Одноклассники</em>)',
            401 => '<strong>Артамонова</strong> (<em>Mail.Ru Group</em>)',
            409 => '<strong>Шульгин</strong> (<em>Яндекс</em>)'
        ];
        return array_values($titles);
    }

    protected function getInternalExportData(Result $result)
    {
        $titles = [
            39 => '<strong>Волож</strong> (<em>Яндекс</em>)',
            40 => '<strong>Гришин</strong> (<em>Mail.Ru&nbsp;Group</em>)',
            41 => '<strong>Дуров</strong> (<em>ex ВКонтакте</em>)',
            403 => '<strong>Рогозов</strong> (<em>ВКонтакте</em>)',
            404 => '<strong>Добродеев</strong> (<em>ВКонтакте, Mail.Ru Group</em>)',
            405 => '<strong>Сергеев</strong> (<em>Mail.Ru Group</em>)',
            42 => '<strong>Молибог</strong> (<em>РБК</em>)',
            43 => '<strong>Пейдж</strong> (<em>Google&nbsp;Global</em>)',
            44 => '<strong>Цукерберг</strong> (<em>Facebook</em>)',
            45 => '<strong>Балмер</strong> (<em>ex Microsoft</em>)',
            406 => '<strong>Наделла</strong> (<em>Microsoft</em>)',
            46 => '<strong>Касперский</strong> (<em>Касперский</em>)',
            47 => '<strong>Белоусов</strong> (<em>Parallels</em>)',
            408 => '<strong>Соловьева</strong> (<em>Google Россия</em>)',
            48 => '<strong>Долгов</strong> (<em>eBay</em>)',
            407 => '<strong>Федчин</strong> (<em>Одноклассники</em>)',
            400 => '<strong>Широков</strong> (<em>Mail.Ru Group, ex Одноклассники</em>)',
            401 => '<strong>Артамонова</strong> (<em>Mail.Ru Group</em>)',
            409 => '<strong>Шульгин</strong> (<em>Яндекс</em>)'
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
