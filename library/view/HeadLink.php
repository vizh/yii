<?php
class HeadLink extends AbstractHead
{
  private $metas = array();
  /**
  * Устанавливает заголовок, принимает  в качестве входного параметра 
  * массив Array('href' => 'путь к файлу', 'rel' => 'отношение с сылающимся файлом', 
  * 'type'=>'Тип', 'title'=>'Тайтл', 'media'=>'Медиа') 
  * параметры title и media являются необязательными 
  * 
  * @param array $args
  */
  public function Add($args)
  {    
    if (is_array($args) && isset($args['href']) && 
      isset($args['rel']) && isset($args['type']))
    {
      $this->links[] = $args;
    }   
    else
    {
      throw new Exception("Неверно переданные аргументы $args в метод Add класс HeadLink");
    }
  }
  /**
  * Преобразует объект HeadMeta в строку для вывода в заголовок
  *   
  */
  protected function toString()
  {
    $result = '';
    foreach ($this->links as $value)
    {
      $media = isset($value['media']) ? 'media="' . $value['media'] . '"' : '';
      $title = isset($value['title']) ? 'title="' . $value['title'] . '"' : '';
      $value['rel'] = 'rel="' . $value['rel'] . '"';
      $value['type'] = 'type="' . $value['type'] . '"';
      $value['href'] = 'href="' . $value['href'] . '"';
      $result .= '<link ' . $value['rel'] . ' ' . $value['type'] . ' ' 
      . $title . ' ' . $media . ' ' . $value['href'] . '>';
      $result .= "\r\n";
    }
    return $result;
  }
}
