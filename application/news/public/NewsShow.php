<?php
// test
AutoLoader::Import('news.source.*');
AutoLoader::Import('news.source.submenu.*');
AutoLoader::Import('library.texts.*');
AutoLoader::Import('comment.source.*');

class NewsShow extends GeneralCommand
{

  protected function preExecute()
  {
    parent::preExecute();

    $this->view->HeaderLogo = '/images/logo_news.png';

    $this->view->HeadScript(array('src'=>'/js/image.viewer.js'));
  }

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($newslink = '')
  {
    if (empty($newslink) || $newslink == 0)
    {
      Lib::Redirect('/');
    }

    $parsedLink = NewsPost::ParseLink($newslink);
    if (empty($parsedLink))
    {
      Lib::Redirect('/');
    }

    $id = intval($parsedLink['id']);
    $news = NewsPost::GetById($id);
    if (($news == null || ($news->Status != NewsPost::StatusPublish && empty($news->CompanyId))
        || $news->Status == NewsPost::StatusDeleted) &&
        !($parsedLink['name'] == 'preview' && $this->LoginUser->IsHaveAdminPermissions()))
    {
      Lib::Redirect('/');
    }
    $titles = Registry::GetWord('titles');
    $this->SetTitle($titles['news'] . ' - ' . $news->Title  );

    $this->view->Date = getdate(strtotime($news->PostDate));
    $this->view->TitleNews = $news->Title;
    $this->view->ContentNews = Texts::AutoPTag($news->Content);
    if (! empty($news->LinkFromRss))
    {
      $this->view->LinkFromRss = $news->LinkFromRss;
    }
    $discImage = $news->GetMainTapeImage(true);
    if (file_exists($discImage))
    {
      $this->view->Image = $news->GetMainTapeImage();
      $this->view->Copyright = $news->Copyright;
    }

    if (! empty($news->MainCategory->PartnerUrl))
    {
      $partner = new View();
      $partner->SetTemplate('banner', 'news', 'banner', '');
      $partner->PartnerUrl = $news->MainCategory->PartnerUrl;
      $partner->PartnerTitle = $news->MainCategory->PartnerTitle;
      $partner->PartnerLogoUrl = $news->MainCategory->GetPartnerLogo();
      $this->view->PartnerBanner = $partner;
    }

    // fill meta
    $view = new View();
    $view->SetTemplate('meta');
    $view->Url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $view->Title = $news->Title;
    $img = $news->GetMainTapeImage(true);
    if (! file_exists($img))
    {
      $img = '/images/mlogobig.png';
    }
    else
    {
      $img = $news->GetMainTapeImage();
    }
    $view->Image = 'http://' . $_SERVER['HTTP_HOST'] . $img;
    $view->Quote = $news->Quote;
    $this->view->MetaTags = $view;

    $this->view->Comments = new CommentViewer($news->NewsPostId, CommentModel::ObjectNews);
    
    $this->view->Url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    $this->view->LastNews = $this->getLastNewsHtml(array($news->NewsPostId));

    $this->view->Categories = new NewsSubmenu($news->Categories);

    if ($news->MainCategory->Special != 0)
    {
      $this->view->BannerInnewsTop = $news->MainCategory->GetSpecialBanner();
    }

    echo $this->view;
  }

  private function getLastNewsHtml($exclude = array())
  {
    $lastNews = NewsPost::GetLastByCompany(3, 1, null, $exclude);

    $lastNewsContainer = new ViewContainer();
    foreach ($lastNews as $news)
    {
      $newsView = new View();
      $newsView->SetTemplate('news');

      $newsView->Link = $news->GetLink();
      $newsView->Date = getdate(strtotime($news->PostDate));
      $newsView->Title = $news->Title;
      $newsView->Quote = $news->Quote;

      $lastNewsContainer->AddView($newsView);
    }

    return $lastNewsContainer;
  }
  
}