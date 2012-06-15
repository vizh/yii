<?php
AutoLoader::Import('news.source.*');
 
class NewsSubmenu
{
  /** @var View */
  private $view;

  /**
   * @param NewsCategories[] $active
   * @param NewsCategories[] $categories
   */
  public function __construct($active = array(), $categories = array())
  {
    $this->view = new View();
    $this->view->SetTemplate('submenu', 'news', 'submenu', '', 'public');

    $activeId = array();
    if (!empty($active))
    {
      foreach ($active as $cat)
      {
        $activeId[] = $cat->NewsCategoryId;
      }
    }

    if (empty($categories))
    {
      $categories = NewsCategories::GetNotEmpty();
    }

    $this->view->ActiveId = $activeId;
    $this->view->Categories = $categories;
  }

  public function __toString()
  {
    return $this->view->__toString();
  }
}
