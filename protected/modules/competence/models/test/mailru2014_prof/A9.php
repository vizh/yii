<?php
namespace competence\models\test\mailru2014_prof;

use competence\models\Result;

class A9 extends \competence\models\form\Base {

  public $value = [];

  public $other;

  protected function getBaseQuestionCode()
  {
    return 'A6';
  }

  protected $options = null;
  public function getOptions()
  {
    if ($this->options == null)
    {
      /** @var A6 $form */
      $form = $this->getBaseQuestion()->getForm();
      $this->options = $form->getOptions();
      $this->options[98] = 'Другое (укажите, какая именно)';
      $this->options[99] = 'Никто из перечисленных';
    }
    return $this->options;
  }

  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Выберите хотя бы один ответ из списка'],
      ['value', 'otherSelectionValidator']
    ];
  }

  public function otherSelectionValidator($attribute, $params)
  {
    if (in_array(98, $this->value) && strlen(trim($this->other)) == 0)
    {
      $this->addError('Other', 'При выборе варианта "Другое" необходимо вписать свой вариант компании');
      return false;
    }
    return true;
  }

  protected function getFormData()
  {
    return ['value' => $this->value, 'other' => $this->other];
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
            12 => 'Одноклассники',
            98 => 'Другое (укажите, какая именно)',
            'other' => 'Другое - значение',
            99 => 'Никто из перечисленных'
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
            12 => 'Одноклассники',
            98 => 'Другое (укажите, какая именно)',
            99 => 'Никто из перечисленных'
        ];
        $keys = array_keys($titles);
        $questionData = $result->getQuestionResult($this->question);
        $data = [];
        foreach ($keys as $key) {
            $data[] = !empty($questionData['value']) && in_array($key, $questionData['value']) ? 1 : '';
            if ($key == 98) {
                $data[] = $questionData['other'];
            }
        }
        return $data;
    }
}
