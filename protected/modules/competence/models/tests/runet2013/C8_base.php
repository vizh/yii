<?php
namespace competence\models\tests\runet2013;

abstract class C8_base extends \competence\models\Question
{
  public function getOptions()
  {
    switch ($this->getMarketId())
    {
      case  1:
        return [[17 => 'Обычная Веб-разработка', 18 => 'Мобильная Веб-разработка'], [19 => 'Веб-студии', 20 => 'Фрилансеры']];
      case  2:
        return [0 => 'Поисковая', 1=> 'Не поисковая'];
      case  3:
        return [];
      case  4:
        return [];
      case  5:
        return [];
      case  6:
        return [];
      case  7:
        return [2 => 'Сегмент B2C', 3 => 'Сегмент B2B'];
      case  8:
        return [4 => 'Хостинг (кроме облачного)', 5 => 'Облачный хостинг'];
      case  9:
        return [];
      case 10:
        return [6  => 'Физические товары, включая продукты питания', 7 => 'Купоны', 8 => 'Билеты (мероприятия)', 9 => 'Бытовые услуги и медицина'];
      case 11:
        return [10 => 'Платежные системы, Мобильные платежи'];
      case 12:
        return [11 => 'Электронные книги', 12 => 'Музыка', 13 => 'Видео', 14 => 'Неигровые приложения'];
      case 13:
        return [15 => 'Билеты (транспорт)', 16 => 'Прочие туристические услуги'];
      case 14:
        return [];
      case 15:
        return [];
      case 16:
        return [];
    }
  }
  
  public function getPrev()
  {
    $nextClass = '\competence\models\tests\runet2013\C7_'.$this->getMarketId();
    return new $nextClass($this->test);
  }
  
  public function getNext()
  {
    $b4Class = '\competence\models\tests\runet2013\B4_'.$this->getMarketId();
    $b4Answer = $this->getFullData()[get_class(new $b4Class($this->test))]['value'];
    if ($b4Answer == B4_base::MARKETANDCOMPANY_VALUE)
    {
      $nextClass = 'C9_'.$this->getMarketId();
    }
    else
    {
      $b2Answer = $this->getFullData()[get_class(new B2($this->test))]['value'];
      sort($b2Answer);
      $key = array_search($this->getMarketId(), $b2Answer);
      if (isset($b2Answer[$key+1]))
        $nextClass = 'B3_'.$b2Answer[$key+1];
      else
        $nextClass = 'D1';
    }
    $nextClass = '\competence\models\tests\runet2013\\'.$nextClass;
    return new $nextClass($this->test);
  }
  
  /**
   * @return int
   */
  abstract public function getMarketId();
  
  /**
   * @return string
   */
  abstract public function getMarketTitle();
  
  protected function getDefinedViewPath()
  {
    return 'competence.views.tests.runet2013.c8';
  }
  
  
  public function rules()
  {
    return [
      ['value', 'filter', 'filter' => [$this, 'filterValue']]
    ];
  }
  
  public function filterValue($value)
  {
    $sum = 0;
    foreach ($value as $val)
    {
      if (!is_numeric($val))
      {
        $this->addError('value', 'Доля рынка должна быть числом');
        break;
      }
      else
        $sum += $val;
    }
    
    if (!$this->hasErrors() && $sum != 100)
    {
      $this->addError('value', 'Сумма долей рынка должна равняться 100%');
    }
    return $value;
  }
}

