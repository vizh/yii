<?php
abstract class AbstractHead
{
  /**
  * Конструктор
  * 
  */
  final public function __construct()
  {
  }
  
  /**
  * Добавляет соответствующие аргументы к заголовку
  * 
  * @param mixed $args
  */
  public abstract function Add($args);  
  
  public function __toString()
  {
    return $this->toString();
  }
  
  protected abstract function toString();
}
