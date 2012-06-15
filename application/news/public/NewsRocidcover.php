<?php
AutoLoader::Import('library.graphics.*');
AutoLoader::Import('news.source.*');
 
class NewsRocidcover extends GeneralCommand
{
  private $coverId;
  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($coverId = 0)
  {
    $this->coverId = intval($coverId);

    if (! empty($coverId))
    {
      $this->view->SetTemplate('success');
      $cover = NewsCover::GetById($this->coverId);
      if (empty($cover))
      {
        Lib::Redirect('/news/rocid-cover/');
      }
      $this->view->CoverImage = $cover->GetResultPath();

      if ($this->LoginUser != null && $this->LoginUser->UserId == $cover->UserId)
      {
        $view = new View();
        $view->SetTemplate('html-code');
        $view->CoverId = $cover->CoverId;
        $view->CoverImage = $cover->GetResultPath();
        $view->Host = $_SERVER['HTTP_HOST'];

        $this->view->HtmlCode = $view;

        $view = new View();
        $view->SetTemplate('bb-code');
        $view->CoverId = $cover->CoverId;
        $view->CoverImage = $cover->GetResultPath();
        $view->Host = $_SERVER['HTTP_HOST'];

        $this->view->BbCode = $view;
      }
    }
    elseif ($this->LoginUser == null)
    {
      $this->view->SetTemplate('notauth');
    }
    else
    {
      $coverTexts = Registry::GetWord('news');
      $firstText = $coverTexts['cover']['first'];
      $secondText = $coverTexts['cover']['second'];;

      $send = Registry::GetRequestVar('send');
      if (! empty($send))
      {
        $firstText = Registry::GetRequestVar('cover-text-first');
        $secondText = Registry::GetRequestVar('cover-text-second');
        if ((!empty($firstText) || !empty($secondText))
            && $_FILES['cover-photo']['error'] == UPLOAD_ERR_OK
            && mb_strlen($firstText, Registry::Encoding) <= NewsCover::TextLengthTop
            && mb_strlen($secondText, Registry::Encoding) <= NewsCover::TextLengthBottom)
        {
          $cover = NewsCover::Generate($firstText, $secondText, 'cover-photo',$this->LoginUser->UserId);
          Lib::Redirect('/news/rocid-cover/' . $cover->CoverId . '/');
        }
      }

      $this->view->FirstText = $firstText;
      $this->view->SecondText = $secondText;
    }



    $this->view->SideBar = $this->getSidebarHtml();

    echo $this->view;
  }

  private function getSidebarHtml()
  {
    $view = new View();
    $view->SetTemplate('sidebar');

    $view->CurrentCover = $this->coverId;
    $exclude = array($this->coverId);

    if ($this->LoginUser != null)
    {
      $covers = NewsCover::GetByUserId($this->LoginUser->UserId, 3, $exclude);
      if (! empty($covers))
      {
        foreach ($covers as $cover)
        {
          $coverView = new View();
          $coverView->SetTemplate('sb-cover-item');

          $coverView->CoverId = $cover->CoverId;
          $coverView->CreationTime = date('d.m.Y H:i', strtotime($cover->CreationTime));

          $coverView->LastName = $cover->User->LastName;
          $coverView->FirstName = $cover->User->FirstName;
          $coverView->RocId = $cover->User->RocId;

          $view->UserCovers .= $coverView;
          $exclude[] = $cover->CoverId;
        }
      }
      else
      {
        $view->UserCovers = null;
      }
    }

    $covers = NewsCover::GetByUserId(null, 3, $exclude);
    if (! empty($covers))
    {
      foreach ($covers as $cover)
      {
        $coverView = new View();
        $coverView->SetTemplate('sb-cover-item');

        $coverView->CoverId = $cover->CoverId;
        $coverView->CreationTime = date('d.m.Y H:i', strtotime($cover->CreationTime));

        $coverView->LastName = $cover->User->LastName;
        $coverView->FirstName = $cover->User->FirstName;
        $coverView->RocId = $cover->User->RocId;

        $view->LastCovers .= $coverView;
        $exclude[] = $cover->CoverId;
      }
    }
    else
    {
      $view->LastCovers = null;
    }

    $banner = new View();
    $banner->SetTemplate('swf', 'core', 'banner', '', 'public');
    $view->Banner = $banner;


    return $view;
  }



}
