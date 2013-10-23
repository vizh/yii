<?php
namespace competence\models\test\student2013;

class Q28_1 extends \competence\models\form\Base
{
  public $value = [];

  protected $rows = null;

  public function getRows()
  {
    if ($this->rows === null)
    {
      $this->rows = $this->rotate('A1_opt', [
        1 => 'Биоинформатика',
        2 => 'Телемедицина',
        3 => '"Умные города"',
        4 => 'Облачные решения',
        5 => 'Дополненная реальность',
        6 => 'Журналистика данных',
        7 => 'Геймификация образования',
        8 => '3D проектирование и печать',
        9 => 'Интернет вещей',
        10 => 'Нейроимпланты',
        11 => 'Робототехника',
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
