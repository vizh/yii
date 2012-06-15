<?php
AutoLoader::Import('video.source.*');
 
class VideoIndex extends GeneralCommand
{
  protected function preExecute()
  {
    parent::preExecute();

    $this->view->HeaderLogo = '/images/logo_video.png';

    $this->view->HeadScript(array('src'=>'/js/libs/jquery.simplemodal.1.4.1.min.js'));
    $this->view->HeadScript(array('src'=>'/js/libs/swfobject.js'));
    $this->view->HeadScript(array('src' => '/js/video.ind.js'));

    $titles = Registry::GetWord('titles');
    $this->SetTitle($titles['video']);
  }

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $videos = VideoPost::GetByCount(19);
    for ($i=0; $i < sizeof($videos); $i++)
    {
      /** @var VideoPost $video  */
      $video = $videos[$i];
      if ($i == 0)
      {
        //$this->view->
        $this->view->Url = $video->GetUrl();
        $this->view->VideoTitle = $video->Title;
        $this->view->Description = $video->Description;
        $this->view->Image = $video->GetThumbnailImageBig();
      }
      else
      {
        $view = new View();
        $view->SetTemplate('video');

        $view->Url = $video->GetUrl();
        $view->Title = $video->Title;
        $view->Image = $video->GetThumbnailImage();
        if ($i < 7)
        {
          $this->view->TopVideo .= $view;
        }
        else
        {
          $this->view->BottomVideo .= $view;
        }
      }

    }

    echo $this->view;
  }
}
