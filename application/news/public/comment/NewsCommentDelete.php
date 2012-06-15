<?php
AutoLoader::Import('news.source.*');
 
class NewsCommentDelete extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($commentId = 0)
  {
    if ($this->LoginUser == null || !$this->LoginUser->IsHaveAdminPermissions())
    {
      Lib::Redirect('/news/');
    }
    $commentId = intval($commentId);
    $comment = NewsComments::GetById($commentId);
    if ($comment == null)
    {
      Lib::Redirect('/news/');
    }

    $newsId = $comment->NewsPostId;

    $comment->delete();

    $news = NewsPost::GetById($newsId);
    if ($news != null)
    {
      Lib::Redirect('/news/' . $news->GetLink());
    }
    else
    {
      Lib::Redirect('/news/');
    }
  }
}
