<?php
AutoLoader::Import('news.source.*');
 
class NewsCategoryList extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $catlist = NewsCategories::GetAll();
    $container = new ViewContainer();
    foreach ($catlist as $cat)
    {
      $view = new View();
      $view->SetTemplate('category');

      $view->NewsCategoryId = $cat->NewsCategoryId;
      $view->Title = $cat->Title;
      $view->Name = $cat->Name;

      $container->AddView($view);
    }

    if (!$container->IsEmpty())
    {
      $this->view->Categories = $container;
    }
    else
    {
      $view = new View();
      $view->SetTemplate('empty');
      $this->view->Categories = $view;
    }

    echo $this->view;
  }
}
