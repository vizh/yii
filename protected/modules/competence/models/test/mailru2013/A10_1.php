<?php
namespace competence\models\tests\mailru2013;

class A10_1 extends \competence\models\Question
{
  public $value = [];

  private $values;
  public function getValues()
  {
    if ($this->values === null)
    {
      $this->values = $this->rotate('A10_1_val', [
        10 => 'Полностью открытая, "прозрачная" компания',
        11 => 'Компания имеет хороший потенциал и перспективы развития',
        12 => 'Компания создает и развивает современные интернет-технологии',
        13 => 'Компания создает и развивает сервисы, которые пользуются большой популярностью',
        14 => 'У компании много лояльных пользователей',
        15 => 'Эта компания вызывает уважение',
        16 => 'У компании выстроены коммуникации с профессиональным сообществом',
        17 => 'Компания обладает сильными конкурентными преимуществами',
        18 => 'У компании выстроены коммуникации  с пользователями',
      ]);
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
    foreach (self::getValues() as $key => $value)
    {
      if (empty($this->value[$key]))
      {
        $this->addError('value', 'Для каждого из высказываний необходимо выбрать хотя бы один подходящий вариант.');
        return false;
      }
    }
    return true;
  }

  /**
   * @return \competence\models\Question
   */
  public function getNext()
  {
    return new S5($this->test);
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    return new A10($this->test);
  }

  public function getNumber()
  {
    return 19;
  }
}
