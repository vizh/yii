<?php
namespace competence\models\tests\mailru2013;

class C5 extends \competence\models\Question
{
  public $values = [
    1 => 'Денег не хватает даже на питание',
    2 => 'На питание денег хватает, но не хватает на покупку одежды и обуви',
    3 => 'На покупку одежды и обуви денег хватает, но не хватает на покупку крупной бытовой техники',
    4 => 'Денег вполне хватает на покупку крупной бытовой техники, но мы не можем купить новую машину',
    5 => 'Денег хватает на все, кроме таких дорогих приобретений, как квартира, дом',
    6 => 'Материальных затруднений не испытываем, при необходимости могли бы приобрести квартиру, дом',
    9 => 'Отказ от ответа',
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
    return new C6($this->test);
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    return new C4($this->test);
  }
}
