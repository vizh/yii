<?php
class HeadStyle extends AbstractHead
{
  private $styles = array();  
  
  /**
  * Устанавливает заголовок, принимает  в качестве входного параметра строку со
  * стилями или массив Array('style' => 'Стили', 'media' => 'all') параметр media вариативный 
  * 
  * @param mixed $args
  */
  public function Add($args)
  {
    if (is_string($args))
    { 
        $this->styles[] = array('style' => $args);     
    }
    elseif (is_array($args) && isset($args['style']))
    {
      $this->styles[] = $args;
    }    
    else
    {
      throw new Exception("Неверно переданные аргументы $args в метод Add класс HeadScript");
    }
  }
  /**
  * Преобразует объект HeadStyle в строку для вывода в заголовок
  *   
  */
  protected function toString()
  {
    $result = '';
    foreach ($this->styles as $value)
    {
      $media = isset($value['media']) ? 'media="'.$value['media'].'"' : '';
      $result .= '<link rel="stylesheet"  type="text/css" ' . $media . ' href="' . $value['style'] . '"/>';
    }
    return $result;
  }
}
