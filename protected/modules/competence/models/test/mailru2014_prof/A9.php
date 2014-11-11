<?php
namespace competence\models\test\mailru2014_prof;

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
}
