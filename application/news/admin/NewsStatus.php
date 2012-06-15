<?php
AutoLoader::Import('news.source.*');

class NewsStatus extends AdminCommand
{

  /**
   * Основные действия комманды
   * @param int $newsPostId
   * @param string $status
   * @return void
   */
  protected function doExecute($newsPostId = 0, $status = NewsPost::StatusPublish)
  {
    $newsPostId = intval($newsPostId);
    $news = NewsPost::GetById($newsPostId);
    $url = '/admin/news/list/';
    if ($news != null)
    {
      $news->Status = $status;
      $news->save();

      if (! empty($news->Companies) != null)
      {
        $url = '/admin/news/list/newscompany/';
      }
    }

    Lib::Redirect($url);
  }
}
 
