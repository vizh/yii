<?php
AutoLoader::Import('news.source.*');
AutoLoader::Import('news.source.submenu.*');
 
class NewsCategory extends GeneralCommand implements ISettingable
{


  /**
   * Возвращает массив вида:
   * array('name1'=>array('DefaultValue', 'Description'),
   *       'name2'=>array('DefaultValue', 'Description'), ...)
   */
  public function GetSettingList()
  {
    return array('NewsCategoryPerPage' => array(10, 'Количество новостей на страницу'));
  }

  protected function preExecute()
  {
    parent::preExecute();

    $this->view->HeaderLogo = '/images/logo_news.png';
  }

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($catName = '', $page = 1)
  {
    $category = NewsCategories::GetByName($catName);

    if (empty($category))
    {
      $this->Send404AndExit();
    }
    $titles = Registry::GetWord('titles');
    $this->SetTitle($titles['news'] . ' - ' . $category->Title  );

    $page = intval($page);
    $page = $page != 0 ? $page : 1;
    $perPage = SettingManager::GetSetting('NewsCategoryPerPage');
    $newslist = $category->GetNews($perPage, $page);
    $allCount = NewsCategories::$GetNewsCountLast;

    $newsContainer = new ViewContainer();
    foreach ($newslist as $news)
    {
      $view = new View();
      $view->SetTemplate('news');

      $view->Link = $news->GetLink();
      $view->Date = date('d.m.Y H:i', strtotime($news->PostDate));
      $view->Title = $news->Title;
      $view->Quote = $news->Quote;
      if (file_exists($news->GetMainTapeImage(true)))
      {
        $view->Image = $news->GetMainTapeImage();
      }

      $newsContainer->AddView($view);
    }

    $this->view->CategoryTitle = $category->Title;
    $this->view->News = $newsContainer;

    if (! empty($category->PartnerUrl))
    {
      $partner = new View();
      $partner->SetTemplate('banner', 'news', 'banner', '');
      $partner->PartnerUrl = $category->PartnerUrl;
      $partner->PartnerTitle = $category->PartnerTitle;
      $partner->PartnerLogoUrl = $category->GetPartnerLogo();
      $this->view->PartnerBanner = $partner;
    }

    $url = '/news/category/' . $catName . '/%s/';
    $this->view->Paginator = new Paginator($url, $page, $perPage, $allCount);

    $this->view->Categories = new NewsSubmenu();

    if ($category->Special != 0)
    {
      $this->view->BannerInnewsTop = $category->GetSpecialBanner();
    }

    echo $this->view;
  }

}