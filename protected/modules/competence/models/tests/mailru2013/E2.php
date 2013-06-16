<?php
namespace competence\models\tests\mailru2013;

class E2 extends \competence\models\Question
{
  public $value = array();

  private $options = null;
  public function getOptions()
  {
    if ($this->options === null)
    {
      $this->options = \competence\models\Question::Rotate('E1_opt', [
        1 => 'Печатные СМИ<br>(<em>специализированные</em>: <strong>Хакер</strong>, <strong>Компьютерра</strong>, <strong>Byte</strong> и т.п.)',
        2 => 'Печатные СМИ<br>(<em>общественно-политические</em>: <strong>Ведомости</strong>, <strong>Newsweek</strong>, <strong>Forbes</strong> и т.п.)',
        3 => 'Печатные СМИ<br>(<em>глянцевые журналы</em>: <strong>Men\'s Health</strong>, <strong>Geo</strong>, <strong>Популярная механика</strong> и т.п.)',
        4 => 'Онлайн СМИ<br>(<em>интернет-издания или интернет-СМИ</em>: <strong>Газета.Ru</strong>, <strong>Lenta.ru</strong>, <strong>Slon.ru</strong>, и т.п.)',
        5 => 'Радио',
        6 => 'Телевидение',
        7 => 'Социальные сети (<strong>Facebook</strong>, <strong>Одноклассники</strong>, <strong>ВКонтакте</strong> и т.п.)',
        8 => 'Социальные СМИ (<strong>Хабрахабр</strong>)',
        9 => 'Социальные СМИ (<strong>Roem.ru</strong>)',
      ]);
      $this->options[10] = 'Другое (добавьте свой вариант СМИ)';
      $this->options[99] = 'Ничего из перечисленного';
    }
    return $this->options;
  }



  public $values = [
    '' => 'Укажите регулярность использования',
    1 => 'Несколько раз в день',
    2 => 'Почти каждый день',
    3 => '2-3 раза в неделю',
    4 => 'Раз в неделю',
    5 => 'Два раза в месяц',
    6 => 'Раз в месяц и реже',
  ];

  public function rules()
  {
    return [
      ['value', 'checkAllValidator']
    ];
  }

  public function checkAllValidator($attribute, $params)
  {
    foreach ($this->value as $value)
    {
      if (empty($value))
      {
        $this->addError('value', 'Необходимо оценить частоту использования всех выбранных СМИ.');
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
    return new E3($this->test);
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    return new E1_1($this->test);
  }
}
