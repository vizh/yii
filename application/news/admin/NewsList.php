<?php
AutoLoader::Import('news.source.*');

class NewsList extends AdminCommand
{
	protected $submenuItems = array();

  const PerPage = 25;

	protected function preExecute()
	{
		parent::preExecute();
		$this->submenuItems = array('news' => array('href' => '/admin/news/list/', 'title' => 'Новости'),
																'newscompany' => array('href' => '/admin/news/list/newscompany/', 'title' => 'Новости из Rss'),
																'category' => array('href' => '/admin/news/list/category/', 'title' => 'Категории'),
																'rss' => array('href' => '/admin/news/list/rss/', 'title' => 'Rss каналы'),
																'promo' => array('href' => '/admin/news/promo/list', 'title' => 'Промо лента'));
	}

	/**
	 * Основные действия комманды
	 * @return void
	 */
	protected function doExecute($page = 1)
	{
    $page = intval($page);
    $page = $page > 1 ? $page : 1;
		$newslist = NewsPost::GetByFromRss(self::PerPage, $page, false);
		$container = new ViewContainer();
		foreach ($newslist as $news)
		{
      if ($news->NewsCategoryId == NewsPost::ExpertsCategoryId)
      {
        continue;
      }
			$view = new View();
			$view->SetTemplate('news');

			$view->NewsPostId = $news->NewsPostId;
			$view->Title = $news->Title;
			$view->Date = getdate(strtotime($news->PostDate));
			$view->Quote = $news->Quote;
			$view->Status = $news->Status;

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
    $url = RouteRegistry::GetAdminUrl('news', '', 'list') . '%s/';
    $this->view->Paginator = new Paginator($url, $page, self::PerPage, NewsPost::$GetByFromRssCount);

		echo $this->view;
	}
}