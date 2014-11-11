<?php
namespace competence\models\test\mailru2014_prof;

class E3 extends \competence\models\form\Base {

  public $options = [
    1 => 'Новости рынка',
    2 => 'Новости компаний',
    3 => 'Технические вопросы',
    4 => 'Информация о профильных мероприятиях',
    5 => 'Новинки сферы (новое ПО, разработки)',
    6 => 'Другое (укажите, что именно)',
  ];

  public $value = [];

  public $other = [];

  protected function getFormData()
  {
    return ['value' => $this->value, 'other' => $this->other];
  }

  protected function getBaseQuestionCode()
  {
    return 'E1_1';
  }

  protected $values = null;

  /**
   * @return array|\competence\models\form\attribute\CheckboxValue[]|null
   */
  public function getValues()
  {
    if ($this->values == null)
    {
      /** @var \competence\models\form\Multiple $form */
      $form = $this->getBaseQuestion()->getForm();
      $result = $this->getBaseQuestion()->getResult();
      if ($result !== null)
      {
        $this->values = [];
        foreach ($form->Values as $value)
        {
          if (in_array($value->key, $result['value']) && !$value->isUnchecker)
          {
            if ($value->isOther)
            {
              $value->isOther = false;
              $value->title = 'Другое (<em>добавлен свой вариант</em>: <strong>'.$result['other'].'</strong>)';
            }
            $this->values[] = $value;
          }
        }
      }
      else
      {
        $this->values = $form->Values;
      }
    }

    return $this->values;
  }

  public function rules()
  {
    return [
      ['value', 'checkAllValidator'],
      ['value', 'checkOtherValidator']
    ];
  }

  public function checkAllValidator($attribute, $params)
  {

    foreach ($this->getValues() as $value)
    {
      if (empty($this->value[$value->key]))
      {
        $this->addError('value', 'Необходимо указать тип получаемой информации для всех выбранных СМИ.');
        return false;
      }
    }
    return true;
  }

  public function checkOtherValidator($attribute, $params)
  {
    foreach ($this->other as $key => $value)
    {
      $this->other[$key] = trim($value);
    }
    foreach ($this->value as $key => $value)
    {
      if (in_array(6, $value) && empty($this->other[$key]))
      {
        $this->addError('value', 'При выборе варианта "Другое", необходимо указать свой тип получаемой информации.');
        return false;
      }
    }
    return true;
  }
}
