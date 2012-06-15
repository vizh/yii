<?php
AutoLoader::Import('news.source.*');

class NewsDelete extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($newsPostId = '')
  {
    $newsPostId = intval($newsPostId);
    $news = NewsPost::GetById($newsPostId);
    $redirect = '/admin/news/list/';
    if ($news != null)
    {
      $news->Status = NewsPost::StatusDeleted;
      $news->save();

      if (! empty($news->LinkFromRss))
      {
        $redirect = '/admin/news/list/newscompany/';
      }
    }


    Lib::Redirect($redirect);
  }
}