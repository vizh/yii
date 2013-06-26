<?php
namespace competence\models\tests\mailru2013;

class A1 extends \competence\models\Question
{

  private $options = null;
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
        401 => '401.png',
        390 => '390.png'
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

  /**
   * @return \competence\models\Question
   */
  public function getNext()
  {
    if (!isset($this->value[49]))
    {
      return new A2($this->test);
    }
    else
    {
      return new A4($this->test);
    }
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    $fullData = $this->getFullData();
    $prev = new E5($this->test);
    if (isset($fullData[get_class($prev)]))
    {
      return $prev;
    }
    $prev = new E1_1($this->test);
    if (isset($fullData[get_class($prev)]))
    {
      return $prev;
    }
    return new E1($this->test);
  }

  public function getNumber()
  {
    return 9;
  }
}
