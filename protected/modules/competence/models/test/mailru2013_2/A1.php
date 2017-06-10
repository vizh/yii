<?php
namespace competence\models\test\mailru2013_2;

class A1 extends \competence\models\form\Base {

  private $options;

  public function getOptions()
  {
    if ($this->options === null)
    {
      $this->options = $this->rotate('A1_opt', [
        39 => '39.png',
        40 => '40.png',
        41 => '41.png',
        42 => '42.png',
        43 => '43.png',
        44 => '44.png',
        45 => '45.png',
        46 => '46.png',
        47 => '47.png',
        48 => '48.png',
        400 => '400.png',
        401 => '401.png'
      ]);
      $this->options[49] = 'unknow.png';
    }
    return $this->options;
  }

  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Отметьте, кого вы знаете, или выберите вариант затрудняюсь ответить.']
    ];
  }

  public function getPrev()
  {
    $e1 = $this->getQuestionByCode('E1');
    if (in_array(99, $e1->getResult()['value']))
    {
      return $e1;
    }
    else
    {
      $e1_1 = $this->getQuestionByCode('E1_1');
      if (in_array(99, $e1_1->getResult()['value']))
      {
        return $e1_1;
      }
    }
    return parent::getPrev();
  }

  public function getNext()
  {
    if (isset($this->value[49]))
    {
      return $this->getQuestionByCode('A4');
    }
    return parent::getNext();
  }


}
