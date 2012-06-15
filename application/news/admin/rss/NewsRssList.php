<?php
AutoLoader::Import('news.source.*');
 
class NewsRssList extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
		$rsslist = NewsRss::GetAll();
		$container = new ViewContainer();
		foreach ($rsslist as $rss)
		{
			$view = new View();
			$view->SetTemplate('rss');

			$view->NewsRssId = $rss->NewsRssId;
			$view->Link = $rss->Link;
			$view->LastUpdate = date('d.m.Y H:i', strtotime($rss->LastUpdate));
			$view->NextUpdate = date('d.m.Y H:i', strtotime($rss->NextUpdate));;
			$view->CompanyId = $rss->Company->CompanyId;
			$view->CompanyName = $rss->Company->Name;

			$container->AddView($view);
		}

		if (!$container->IsEmpty())
		{
			$this->view->Rss = $container;
		}
		else
		{
			$view = new View();
			$view->SetTemplate('empty');
			$this->view->Rss = $view;
		}

    echo $this->view;
  }
}
