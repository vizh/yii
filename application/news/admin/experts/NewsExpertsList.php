<?php
AutoLoader::Import('news.source.*');
 
class NewsExpertsList extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $newslist = NewsPost::GetByCategory(NewsPost::ExpertsCategoryId, 50, 1, false, array(), null);
    $this->view->SetTemplate('list');
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
      if (! empty($news->Author))
      {
        $view->Author = $news->Author->LastName . ' ' . $news->Author->FirstName;
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
