<?php
namespace competence\models\test\student2013;

class Q28_1 extends \competence\models\form\Base
{
  public $value = [];

  protected $rows;

  public function getRows()
  {
    if ($this->rows === null)
    {
      $this->rows = $this->rotate('A1_opt', [
        1 => 'Биоинформатика и ИТ в медицине',
        2 => '"Умные города"',
        3 => 'Облачные технологии',
        4 => 'Информатика в статистике (data science), data-журналистика',
        5 => 'ИТ в образовании',
        6 => '3D-проектирование и печать',
        7 => 'Дополненная и виртуальная реальность',
        8 => 'Интернет вещей',
        9 => 'Робототехника и ПО для роботов',
        10 => 'Компьютерная лингвистика и искусственный интеллект',
      ]);
    }
    return $this->rows;
  }

  public function getOptions()
  {
    return [
      1 => 'ничего не знаю об этом',
      2 => 'что-то знаю, но мне это интересно',
      3 => 'что-то знаю и возможно хотел бы работать в этой сфере'
    ];
  }


}
