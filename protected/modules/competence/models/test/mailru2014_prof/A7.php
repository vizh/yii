<?php
namespace competence\models\test\mailru2014_prof;

use competence\models\Result;

class A7 extends \competence\models\form\Base {

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
    1 => '… интересной',
    2 => '… понятной',
    3 => '… полезной',
    9 => 'Ничего из перечисленного'
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
        $this->addError('value', 'Необходимо отметить качество полученной информации для каждой из указанных компаний.');
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
