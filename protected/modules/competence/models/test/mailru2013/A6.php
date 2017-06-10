<?php
namespace competence\models\tests\mailru2013;

class A6 extends \competence\models\Question
{
  public $value = [];

  private $options;
  public function getOptions()
  {
    if ($this->options === null)
    {
      $this->options = $this->rotate('A6_opt', [
        1 => 'Яндекс',
        2 => 'Mail.Ru Group',
        3 => 'Google Russia',
        4 => 'ВКонтакте',
        5 => 'Рамблер-Афиша-SUP',
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

  /**
   * @return \competence\models\Question
   */
  public function getNext()
  {
    if (!in_array(99, $this->value))
    {
      return new A6_1($this->test);
    }
    else
    {

      $unset = [
        get_class(new A6_1($this->test)),
      ];
      $this->clearFullDataPart($unset);
      return new A8($this->test);
    }
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    $fullData = $this->getFullData();
    $prev = new A5($this->test);
    if (isset($fullData[get_class($prev)]))
    {
      return $prev;
    }
    return new A4($this->test);
  }

  public function getNumber()
  {
    return 13;
  }
}
