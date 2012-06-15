<?php
class HeadScript extends AbstractHead
{
  private $sources = array();
  private $scripts = array();
  
  /**
  * Устанавливает заголовок, принимает  в качестве входного параметра строку с путем к
  * JS файлу или массив Array('src' => 'ПутьКJS') или array('script' => 'JS Код') 
  * 
  * @param mixed $args
  */
  public function Add($args)
  {
    if (is_string($args))
    { 
      if (! in_array($args, $this->sources))
      {
        $this->sources[] = $args;
      }      
    }
    elseif (is_array($args))
    {
      if (isset($args['src']))
      {
        if (! in_array($args['src'], $this->sources))
        {
          $this->sources[] = $args['src'];
        }
      }
      elseif (isset($args['script']))
      {
        $this->scripts[] = $args['script'];
      }
      else
      {
        throw new Exception("Неверно переданные аргументы $args в метод Add класс HeadScript");
      }
    }    
    else
    {
      throw new Exception("Неверно переданные аргументы $args в метод Add класс HeadScript");
    }
  }
  /**
  * Преобразует объект HeadScript в строку для вывода в заголовок
  *   
  */
  protected function toString()
  {
    $result = '';
    foreach ($this->sources as $value)
    {
      $result .= '<script type="text/javascript" src="'.$value.'"></script>'. "\r\n";
    }
    foreach ($this->scripts as $value)
    {
      $result .= '<script type="text/javascript">'.$value.'</script>';
    }
    return $result;
  }
}
