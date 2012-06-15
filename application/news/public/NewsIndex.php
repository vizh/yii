<?php
AutoLoader::Import('news.source.*');
AutoLoader::Import('news.source.submenu.*');
AutoLoader::Import('library.texts.*');

class NewsIndex extends GeneralCommand implements ISettingable
{
  /**
   * Возвращает массив вида:
   * array('name1'=>array('DefaultValue', 'Description'),
   *       'name2'=>array('DefaultValue', 'Description'), ...)
   */
  public function GetSettingList()
  {
    return array('ExpertTapeCount' => array(4, 'Количество записей экспертов в ленте'));
  }

  const CacheNewsHtml = 'news/index_news';

  protected function preExecute()
  {
    parent::preExecute();

    $this->view->HeaderLogo = '/images/logo_news.png';

    $titles = Registry::GetWord('titles');
    $this->SetTitle($titles['news']);

    $this->view->HeadScript(array('src'=>'/js/libs/jquery.jcarousel.min.js'));
		$this->view->HeadScript(array('src'=>'/js/jquery.jcarousel.js'));

    $this->view->HeadLink(array('rel' => 'alternate', 'type' => 'application/rss+xml',
                               'title' => $titles['news'], 'href' => RouteRegistry::GetUrl('news', '', 'rss')));
  }

  private $exclude = array();


  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $this->view->TopNews = $this->getTopNewsHtml();

    $this->view->Categories = new NewsSubmenu();

    $titles = Registry::GetWord('titles');
    $categories = NewsCategories::GetAll(true);
    foreach ($categories as $category)
    {
      $this->view->HeadLink(array('rel' => 'alternate', 'type' => 'application/rss+xml',
                                 'title' => $titles['news'] . ' / ' . $category->Title,
                                 'href' => RouteRegistry::GetUrl('news', 'rss', 'category', array('name' => $category->Name))));
    }

    $news = Registry::GetCache()->get(self::CacheNewsHtml);
    //$news = false;
    if ($news === false)
    {
      $newsContainer = new ViewContainer();
      foreach ($categories as $category)
      {
        if ($category->NewsCategoryId == NewsPost::ExpertsCategoryId)
        {
          continue;
        }
        $result = $this->getNewsHtml($category);
        if (! empty($result))
        {
          $newsContainer->AddView($result);
        }
      }
      $news = (string) $newsContainer;
      $dependency = new CDbCacheDependency('SELECT MAX(UpdateTime) FROM Mod_NewsPost');
      Registry::GetCache()->set(self::CacheNewsHtml, $news, 24 * 60 *60, $dependency);
    }

    $this->view->News = $news;

    $this->view->ExpertsTape = $this->getExpertsTapeHtml();

    echo $this->view;
  }

  private function getTopNewsHtml()
  {
    $topNews = NewsPost::GetLastTop(3);
    if (empty($topNews) || sizeof($topNews) < 3)
    {
      return '';
    }

    $view = new View();
    $view->SetTemplate('topnews');
    $view->MainNews = $topNews[0];
    //$this->exclude[] = $topNews[0]->NewsPostId;
    $centerNews = array();
    for($i=1; $i < sizeof($topNews); $i++ )
    {
      $centerNews[] = $topNews[$i];
      //$this->exclude[] = $topNews[$i]->NewsPostId;
    }
    $view->CenterNews = $centerNews;

    $viewAds = new View();
    $viewAds->SetTemplate('swf', 'core', 'banner', '', 'public');
    $view->Banner = $viewAds;

    return $view;
  }

  /**
   * @param NewsCategories $category
   * @return View
   */
  private function getNewsHtml($category)
  {
    $news = NewsPost::GetByCategory($category->NewsCategoryId, 5, 1, false, $this->exclude);

    if (empty($news))
    {
      return '';
    }
    $view = new View();
    $view->SetTemplate('categorynews');

    $view->Category = $category;
    $view->RssUrl = RouteRegistry::GetUrl('news', 'rss', 'category', array('name' => $category->Name));

    $count = sizeof($news);

    $left = new ViewContainer();
    $center = new ViewContainer();
    $right = new ViewContainer();
    for ($i=0; $i<sizeof($news); $i++ )
    {
      /** @var NewsPost $single */
      $single = $news[$i];
      $viewSingle = new View();
      $viewSingle->Link = $single->GetLink();
      $viewSingle->Title = $single->Title;
      $viewSingle->Quote = $single->Quote;
      $viewSingle->Date = date('d.m.Y H:i', strtotime($single->PostDate));
      $viewSingle->MaterialType = $single->MaterialType;

      $column = $i % 3;
      if ($i == 0)
      {
        $viewSingle->SetTemplate('imagednews');
        $viewSingle->Image = $single->GetMainTapeImageBig();
        $left->AddView($viewSingle);
      }
      else
      {
        $viewSingle->SetTemplate('news');

        if (($i < 3 && $count > 3) || $i < 2)
        {
          $center->AddView($viewSingle);
        }
        else
        {
          $right->AddView($viewSingle);
        }
      }
    }

    $view->Left = $left;
    $view->Center = $center;
    $view->Right = $right;

    return $view;
  }

  private function getExpertsTapeHtml()
  {
    $tape = new View();
    $tape->SetTemplate('promotape', 'main', 'index', '');
    $tape->ShowHeader = false;
    $tapeCount = SettingManager::GetSetting('ExpertTapeCount');
    $newslist = NewsPost::GetByCategory(NewsPost::ExpertsCategoryId, $tapeCount);
    if (empty($newslist))
    {
      return '';
    }
    $newslist = array_reverse($newslist);
    $container = new ViewContainer();
    foreach($newslist as $news)
    {
      $item = new View();
      $item->SetTemplate('promo', 'main', 'index', '');
      $item->Link = RouteRegistry::GetUrl('news', '', 'show', array('newslink' => $news->GetLink()));
      $item->Image = $news->GetMainTapeImage();
      if (! empty($news->Author))
      {
        $item->TitleTop = $news->Author->LastName . ' ' . $news->Author->FirstName;
      }
      $item->Title = $news->Title;
      $item->Description = $news->Quote;
      $container->AddView($item);
    }
    $tape->PromoList = $container;
    return $tape;
  }


}
