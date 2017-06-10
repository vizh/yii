<?php
namespace competence\models\tests\mailru2013;

class E1_1 extends \competence\models\Question
{
  private $options;
  public function getOptions()
  {
    if ($this->options === null)
    {
      $this->options = [
        1 => 'Печатные СМИ (<em>специализированные</em>: <strong>Хакер</strong>, <strong>Компьютерра</strong>, <strong>Byte</strong> и т.п.)',
        2 => 'Печатные СМИ (<em>общественно-политические</em>: <strong>Ведомости</strong>, <strong>Newsweek</strong>, <strong>Forbes</strong> и т.п.)',
        3 => 'Печатные СМИ (<em>глянцевые журналы</em>: <strong>Men\'s Health</strong>, <strong>Geo</strong>, <strong>Популярная механика</strong> и т.п.)',
        4 => 'Онлайн СМИ (<em>интернет-издания или интернет-СМИ</em>: <strong>Газета.Ru</strong>, <strong>Lenta.ru</strong>, <strong>Slon.ru</strong>, и т.п.)',
        5 => 'Радио',
        6 => 'Телевидение',
        7 => 'Социальные сети (<strong>Facebook</strong>, <strong>Одноклассники</strong>, <strong>ВКонтакте</strong> и т.п.)',
        8 => 'Хабрахабр',
        9 => 'Roem.ru',
        10 => 'Цукерберг позвонит',
        11 => 'Другие специализированные социальные СМИ'
      ];
      $this->options[12] = 'Другое (свой вариант СМИ)';
      $this->options[99] = 'Ничего из перечисленного';
    }
    return $this->options;
  }

  public $value = [];

  public $other;

  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Выберите хотя бы один ответ из списка'],
      ['value', 'otherSelectionValidator']
    ];
  }

  public function otherSelectionValidator($attribute, $params)
  {
    if (in_array(12, $this->value) && strlen(trim($this->other)) == 0)
    {
      $this->addError('Other', 'При выборе варианта "Другое" необходимо вписать свой вариант СМИ');
      return false;
    }
    return true;
  }

  /**
   * @return array
   */
  protected function getQuestionData()
  {
    return ['value' => $this->value, 'other' => $this->other];
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
    return null;
  }

  public function getNumber()
  {
    return 4;
  }
}
