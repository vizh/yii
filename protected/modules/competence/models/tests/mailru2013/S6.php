<?php
namespace competence\models\tests\mailru2013;

class S6 extends \competence\models\Question
{

  public $other;

  public $values = [
    1 => '1-10 человек',
    2 => '11-50 человек',
    3 => '51-100 человек',
    4 => '101-200 человек',
    5 => '201-500 человек',
    6 => 'Более 500 человек',
    99 => 'Ничего из перечисленного'
  ];

  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Выберите один ответ из списка']
    ];
  }

  /**
   * @return \competence\models\Question
   */
  public function getNext()
  {
    $fullData = $this->getFullData();
    $s5Data = $fullData[get_class(new S5($this->test))];
    if (in_array($s5Data['value'], array(1, 2, 3)))
    {
      return new S7($this->test);
    }
    else
    {
      $first = new First($this->test);
      return $first->getS3();
    }
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    return new S5($this->test);
  }

  public function getNumber()
  {
    return 21;
  }
}
