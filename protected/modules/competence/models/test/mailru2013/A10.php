<?php
namespace competence\models\tests\mailru2013;

class A10 extends \competence\models\Question
{
  public $value = [];

  private $options = null;
  public function getOptions()
  {
    if ($this->options === null)
    {
      $this->options = $this->rotate('A10_opt', [
        83 => 'Mail.Ru',
        84 => 'Яндекс',
        85 => 'Google',
        86 => 'Facebook',
        87 => 'Одноклассники',
        88 => 'Rambler',
        89 => 'ВКонтакте'
      ]);
      $this->options[90] = 'Не подходит ни к одной компании';
    }
    return $this->options;
  }

  private $values = null;
  public function getValues()
  {
    if ($this->values === null)
    {
      $this->values = $this->rotate('A10_val', [
        1 => 'Я часто пользуюсь продуктами / услугами этой компании',
        2 => 'Эта компания занимает прочную позицию на рынке',
        3 => 'Я слежу за всеми новостями, касающимися этой компании',
        4 => 'Мне понятны основные принципы политики и стратегия этой компании',
        5 => 'Это динамично развивающаяся компания',
        6 => 'Лидер инноваций в своей сфере',
        7 => 'В этой компании работают самые крупные специалисты данной сферы',
        8 => 'Я хотел бы работать в этой компании',
        9 => 'Компания прислушивается к своим пользователям',
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
    return new A10_1($this->test);
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    return new A9($this->test);
  }

  public function getNumber()
  {
    return 18;
  }
}