<?php
AutoLoader::Import('news.source.*');
 
class JobSubmenu
{
  /** @var View */
  private $view;

  /**
   * @param string $active
   */
  public function __construct($active)
  {
    $this->view = new View();
    $this->view->SetTemplate('submenu', 'job', 'submenu', '', 'public');
    $this->view->Active = $active;
  }

  public function __toString()
  {
    return $this->view->__toString();
  }
}
