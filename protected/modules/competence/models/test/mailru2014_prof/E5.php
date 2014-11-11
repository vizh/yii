<?php
namespace competence\models\test\mailru2014_prof;

class E5 extends \competence\models\form\Base {

  public $options = [
    300 => 'Независимые эксперты',
    301 => 'Официальные представители компаний',
    302 => 'Представители независимых аналитических агентств',
    303 => 'Представители государственных структур',
    304 => 'Блоггеры',
    305 => 'Информационные агентства (журналисты)',
  ];

  public $values = [
    '' => 'Укажите степень доверия',
    5 => 'Полностью доверяю',
    4 => 'Скорее доверяю',
    3 => 'Частично доверяю, частично нет',
    2 => 'Скорее не доверяю',
    1 => 'Абсолютно не доверяю',
  ];

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
        $this->addError('value', 'Необходимо оценить степень доверия информации, полученной от всех представленных лиц.');
        return false;
      }
    }
    return true;
  }

  public function getNext()
  {
    $a1 = $this->getQuestionByCode('A1');
    $a1Result = $a1->getResult();
    if (empty($a1Result))
    {
      return $this->getQuestionByCode('A1');
    }
    else
    {
      $a2 = $this->getQuestionByCode('A2');
      $a2Result = $a2->getResult();
      if (empty($a2Result))
      {
        return $this->getQuestionByCode('A2');
      }
    }
    return $this->getQuestionByCode('A4');
  }
}