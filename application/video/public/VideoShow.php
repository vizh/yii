<?php
AutoLoader::Import('video.source.*');

class VideoShow extends AjaxNonAuthCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($videolink = '')
  {
    if (empty($videolink) || $videolink == 0)
    {
      echo json_encode(array());
      exit;
    }

    $parsedLink = VideoPost::ParseLink($videolink);
    if (empty($parsedLink))
    {
      echo json_encode(array());
      exit;
    }

    $id = intval($parsedLink['id']);
    $video = VideoPost::GetById($id);
    if ($video == null || $video->Status != VideoPost::StatusPublish)
    {
      echo json_encode(array());
      exit;
    }

    echo json_encode(array('video' => $video->Link));
  }
}
 
