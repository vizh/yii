<?php
namespace competence\models\tests\mailru2013;

class A4 extends \competence\models\Question
{
  public $value = array();

  private $options;
  public function getOptions()
  {
    if ($this->options === null)
    {
      $this->options = $this->rotate('A2_opt', [
        39 => '<strong>Волож</strong> (<em>Яндекс</em>)',
        40 => '<strong>Гришин</strong> (<em>Mail.Ru&nbsp;Group</em>)',
        41 => '<strong>Дуров</strong> (<em>ВКонтакте</em>)',
        42 => '<strong>Молибог</strong> (<em>ex-Рамблер</em>)',
        43 => '<strong>Пейдж</strong> (<em>Google&nbsp;Global</em>)',
        44 => '<strong>Цукерберг</strong> (<em>Facebook</em>)',
        45 => '<strong>Балмер</strong> (<em>Microsoft</em>)',
        46 => '<strong>Касперский</strong> (<em>Касперский</em>)',
        47 => '<strong>Белоусов</strong> (<em>Parallels</em>)',
        48 => '<strong>Долгов</strong> (<em>ex-Google&nbsp;Russia</em>)',
        400 => '<strong>Широков</strong> (<em>Одноклассники</em>)',
        401 => '<strong>Артамонова</strong> (<em>Mail.ru Group</em>)',
        402 => '<strong>Захаров</strong> (<em>Рамблер-Афиша-SUP</em>)'
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
      return new A5($this->test);
    }
    else
    {
      return new A6($this->test);
    }
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    $fullData = $this->getFullData();
    $prev = new E2($this->test);
    if (isset($fullData[get_class($prev)]))
    {
      return $prev;
    }
    return new E1_1($this->test);
  }

  public function getNumber()
  {
    return 11;
  }
}
