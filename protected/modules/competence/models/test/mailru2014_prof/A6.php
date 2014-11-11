<?php
namespace competence\models\test\mailru2014_prof;

class A6 extends \competence\models\form\Base {

  public $value = [];

  private $options = null;
  public function getOptions()
  {
    if ($this->options === null)
    {
      $this->options = $this->rotate('A6_opt', [
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
      ]);
    }
    return $this->options;
  }

  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Отметьте, о ком вы слышали, или выберите вариант затрудняюсь ответить.']
    ];
  }

  public function getPrev()
  {
    $a4 = $this->getQuestionByCode('A4');
    if (in_array(99, $a4->getResult()['value']))
    {
      return $a4;
    }

    return parent::getPrev();
  }

  public function getNext()
  {
    if (in_array(99, $this->value))
    {
      return $this->getQuestionByCode('A8');
    }
    return parent::getNext();
  }
}
