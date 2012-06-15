<?php
AutoLoader::Import('news.source.*');
 
class NewsCompanyList extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $newslist = NewsPost::GetByFromRss(100, 1, true);
    $container = new ViewContainer();
    foreach ($newslist as $news)
    {
      $view = new View();
      $view->SetTemplate('news');

      $view->NewsPostId = $news->NewsPostId;
      $view->Title = $news->Title;
      $view->Date = getdate(strtotime($news->PostDate));
      $view->Quote = $news->Quote;
      $view->Status = $news->Status;
      if (sizeof($news->Companies) == 1)
      {
        $view->CompanyName = $news->Companies[0]->Name;
      }
      else
      {
        $view->CompanyName = 'TODO: подумать как выводить несколько компаний';
      }

      $container->AddView($view);
    }

    if (!$container->IsEmpty())
    {
      $this->view->News = $container;
    }
    else
    {
      $view = new View();
      $view->SetTemplate('empty');
      $this->view->News = $view;
    }

    echo $this->view;
  }
}
