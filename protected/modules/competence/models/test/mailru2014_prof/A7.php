<?php
namespace competence\models\test\mailru2014_prof;

class A7 extends \competence\models\form\Base {

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
}
