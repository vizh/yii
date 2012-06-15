<?php
class ViewContainer
{
  /**
   * @var View[]
   */
  private $views = array();
  
  /**
  * Добавляет объект View в контейнер хранимых видов
  * 
  * @param View $view
  */
  public function AddView(View $view)
  {
    $this->views[] = $view;
  }
  /**
  * Проверяет на пустоту контейнер
  * @return bool
  */
  public function IsEmpty()
  {
    return sizeof($this->views) === 0;
  }

  /**
   * Выводит количество добавленных в контейнер View
   * @return int
   */
  public function Count()
  {
    return sizeof($this->views);
  }
  
  /**
  * Рендеринг ответа пользователю
  * 
  * @return Возвращает отрендереное содержимое видов находящихся в контейнере
  */  
  public function __toString()  
  {
    $out = '';
    foreach ($this->views as $view)
    {
      $out .= $view->__toString();
    }
    return $out;
  }
}