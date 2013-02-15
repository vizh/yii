<?php
namespace partner\components;


class Controller extends \application\components\controllers\PublicMainController
{
  public $layout = '/layouts/public';

  public function filters()
  {
    $filters = parent::filters();
    return array_merge(
      $filters,
      array(
        'checkEventId'
      )
    );
  }
  /**
   * @param \CFilterChain $filterChain
   */
  public function filterCheckEventId($filterChain)
  {
    //todo: Проверить на админство, если не установлен закрепленный аккаунт - редирект на страницу установки
    $filterChain->run();
  }

  protected $bottomMenu = array();
  protected function initBottomMenu() {}
  
  public function initActiveBottomMenu($active)
  {
    $this->initBottomMenu();
    foreach ($this->bottomMenu as $key => $value)
    {
      $this->bottomMenu[$key]['Active'] = ($key == $active);
    }
  }

  public function getBottomMenu()
  {
    return $this->bottomMenu;
  }
}