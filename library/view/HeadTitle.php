<?php
class HeadTitle extends AbstractHead
{
  private $title = '';
  
  /**
  * Устанавливает заголовок, принимает  в качестве входного параметра string Заголовок
  * или array('title'=>'Заголовок')
  * 
  * @param mixed $args
  */
  public function Add($args)
  {
    if (is_string($args))
    {
      $this->title = $args;
    }
    elseif (is_array($args) && isset($args['title']))
    {
      $this->title = $args['title'];
    }
    else
    {
      throw new Exception("Неверно переданные аргументы $args в метод Add класс HeadTitle");
    }
  }
  
  /**
  * Преобразует объект HeadTitle в строку для вывода в заголовок
  *   
  */
  protected function toString()
  {
    return '<title>'.$this->title.'</title>';
  }
}
