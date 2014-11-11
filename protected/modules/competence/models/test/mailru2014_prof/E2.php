<?php
namespace competence\models\test\mailru2014_prof;

class E2 extends \competence\models\form\Base {
  protected function getBaseQuestionCode()
  {
    return 'E1_1';
  }

  public $options = [
    '' => 'Укажите регулярность использования',
    1 => 'Несколько раз в день',
    2 => 'Почти каждый день',
    3 => '2-3 раза в неделю',
    4 => 'Раз в неделю',
    5 => 'Два раза в месяц',
    6 => 'Раз в месяц и реже',
  ];

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
      ['value', 'checkAllValidator']
    ];
  }

  public function checkAllValidator($attribute, $params)
  {
    foreach ($this->value as $value)
    {
      if (empty($value))
      {
        $this->addError('value', 'Необходимо оценить частоту использования всех выбранных СМИ.');
        return false;
      }
    }
    return true;
  }
}
