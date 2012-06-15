<?php
class HeadMeta extends AbstractHead
{
  private $metas = array();
  /**
  * Устанавливает заголовок, принимает  в качестве входного параметра 
  * массив Array('content' => 'Контент', 'http-equiv' => 'идентификатор', 
  * 'name'=>'идентификатор') параметры name и http-equiv могут использоваться или/или 
  * 
  * @param mixed $args
  */
  public function Add($args)
  {
    if (is_array($args) && isset($args['content']) && 
      (isset($args['http-equiv']) || isset($args['name'])))
    {
      $this->metas[] = $args;
    }   
    else
    {
      throw new Exception("Неверно переданные аргументы $args в метод Add класс HeadMeta");
    }
  }
  /**
  * Преобразует объект HeadMeta в строку для вывода в заголовок
  *   
  */
  protected function toString()
  {
    $result = '';
    foreach ($this->metas as $value)
    {
      $name = isset($value['name']) ? 'name="' . $value['name'] . '"' : '';
      $httpEquiv = isset($value['http-equiv']) ? 
        'http-equiv="' . $value['http-equiv'] . '"' : '';
      $value['content'] = 'content="' . $value['content'] . '"';
      $result .= '<meta ' . $httpEquiv . ' ' . $name . ' ' . $value['content'] . '>'. "\r\n";
    }
    return $result;
  }
}
