<?php
namespace competence\models\tests\mailru2013;

class E1_1 extends \competence\models\Question
{
  public $value = array();

  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Выберите хотя бы один ответ из списка']
    ];
  }

  /**
   * @return \competence\models\Question
   */
  public function getNext()
  {
    if (!in_array(99, $this->value))
    {
      return new E2($this->test);
    }
    else
    {
      $unset = [
        get_class(new E2($this->test)),
        get_class(new E3($this->test)),
        get_class(new E4($this->test)),
        get_class(new E5($this->test))
      ];
      $this->clearFullDataPart($unset);

      $fullData = $this->getFullData();
      $next = new A1($this->test);
      if (!isset($fullData[get_class($next)]))
      {
        return $next;
      }
      $A1data = $fullData[get_class($next)];
      $next = new A2($this->test);
      if (!isset($fullData[get_class($next)]) && !isset($A1data['value'][49]))
      {
        return $next;
      }
      return new A4($this->test);
    }
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    return new E1($this->test);
  }
}
