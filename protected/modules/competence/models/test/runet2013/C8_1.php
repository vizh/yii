<?php
namespace competence\models\tests\runet2013;

class C8_1 extends C8_base
{
  public function getMarketId()
  {
    return 1;
  }

  public function getMarketTitle()
  {
    return 'Веб-разработка';
  }  
  
  protected function getDefinedViewPath()
  {
    return 'competence.views.tests.runet2013.c8_1';
  }
  
  public function rules()
  {
    return [
      ['value', 'filter', 'filter' => [$this, 'filterValue']]
    ];
  }
  
  public function filterValue($value)
  {
    foreach ($value as $val)
    {
      if (!is_numeric($val)) 
      {
        $this->addError('value', 'Доля рынка должна быть числом');
        break;
      }
    }
    
    if (!$this->hasErrors())
    {
      foreach ($this->getOptions() as $options)
      {
        $sum = 0;
        foreach ($options as $key => $val)
          $sum += $value[$key];
        
        if ($sum != 100)
        {
          $this->addError('value', 'Cумма долей рынка в группе должна равняться 100%');
          break;
        }
      }
    }
    return $value;
  }
}
