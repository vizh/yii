<?php
namespace competence\models\test\mailru2016_prof;

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
    1 => 'Печатные СМИ (общественно-политические: Ведомости, Коммерсантъ, Forbes и т.п.)',
    4 => 'Онлайн СМИ (интернет- издания или интернет-СМИ: Газета.ru, Lenta.ru, Slon.ru и т.п.)',
    5 => 'Западные новые медиа (например,TechCrunch, Mashable, TheVerge, Vox и т.п.)',
    6 => 'Радио',
    7 => 'Телевидение',
    8 => 'Социальные сети (ВКонтакте, Facebook, Одноклассники, и т.п.)',
    9 => 'Социальные СМИ (Хабрахабр, Roem.ru, Цукерберг позвонит)',
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
            40 => '<strong>Гришин</strong> (<em>Mail.Ru&nbsp;Group</em>)',
            41 => '<strong>Дуров</strong> (<em>Telegram</em>)',
            404 => '<strong>Добродеев</strong> (<em>Mail.Ru Group, ВКонтакте</em>)',
            403 => '<strong>Рогозов</strong> (<em>Mail.Ru Group, ВКонтакте</em>)',
            405 => '<strong>Сергеев Дмитрий</strong> (<em>Mail.Ru Group</em>)',
            42 => '<strong>Молибог</strong> (<em>РБК</em>)',
            43 => '<strong>Пейдж</strong> (<em>Alphabet, Google Global</em>)',
            44 => '<strong>Цукерберг</strong> (<em>Facebook</em>)',
            406 => '<strong>Сатья Наделла</strong> (<em>Microsoft</em>)',
            46 => '<strong>Касперский</strong> (<em>Касперский</em>)',
            47 => '<strong>Белоусов</strong> (<em>Acronis, Parallels</em>)',
            408 => '<strong>Соловьева</strong> (<em>Google Россия</em>)',
            48 => '<strong>Долгов</strong> (<em>eBay</em>)',
            407 => '<strong>Федчин</strong> (<em>Mail.Ru Group, Одноклассники</em>)',
            409 => '<strong>Шульгин</strong> (<em>Яндекс</em>)',
            401 => '<strong>Артамонова Анна</strong> (<em>Mail.Ru Group</em>)'
        ];
        return array_values($titles);
    }

    protected function getInternalExportData(Result $result)
    {
        $titles = [
            40 => '<strong>Гришин</strong> (<em>Mail.Ru&nbsp;Group</em>)',
            41 => '<strong>Дуров</strong> (<em>Telegram</em>)',
            404 => '<strong>Добродеев</strong> (<em>Mail.Ru Group, ВКонтакте</em>)',
            403 => '<strong>Рогозов</strong> (<em>Mail.Ru Group, ВКонтакте</em>)',
            405 => '<strong>Сергеев Дмитрий</strong> (<em>Mail.Ru Group</em>)',
            42 => '<strong>Молибог</strong> (<em>РБК</em>)',
            43 => '<strong>Пейдж</strong> (<em>Alphabet, Google Global</em>)',
            44 => '<strong>Цукерберг</strong> (<em>Facebook</em>)',
            406 => '<strong>Сатья Наделла</strong> (<em>Microsoft</em>)',
            46 => '<strong>Касперский</strong> (<em>Касперский</em>)',
            47 => '<strong>Белоусов</strong> (<em>Acronis, Parallels</em>)',
            408 => '<strong>Соловьева</strong> (<em>Google Россия</em>)',
            48 => '<strong>Долгов</strong> (<em>eBay</em>)',
            407 => '<strong>Федчин</strong> (<em>Mail.Ru Group, Одноклассники</em>)',
            409 => '<strong>Шульгин</strong> (<em>Яндекс</em>)',
            401 => '<strong>Артамонова Анна</strong> (<em>Mail.Ru Group</em>)'
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
