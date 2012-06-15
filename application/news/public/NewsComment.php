<?php
AutoLoader::Import('news.source.*');
 
class NewsComment extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($newsPostId = 0, $parentId = 0)
  {    
    $newsPostId = intval($newsPostId);
    $parentId = intval($parentId);
    $news = NewsPost::GetById($newsPostId);
    if ($news == null)
    {
      Lib::Redirect('/news/');
    }

    if ($this->LoginUser == null)
    {
      Lib::Redirect('/news/' . $news->GetLink());
    }

    $parent = null;
    if ($parentId != 0)
    {
      $parent = NewsComments::GetById($parentId);
    }

    $commentContent = Registry::GetRequestVar('comment');

    $comment = new NewsComments();
    if ($parent != null)
    {
      $comment->ParentId = $parent->CommentId;
    }
    $comment->UserId = $this->LoginUser->UserId;
    $comment->PostDate = date('Y-m-d H:i:s', time());
    $comment->NewsPostId = $news->NewsPostId;
    $comment->SetContent($commentContent);
    $content = trim($comment->Content);
    if (empty($content))
    {
      Lib::Redirect('/news/' . $news->GetLink());
    }
    $comment->save();

    Lib::Redirect('/news/' . $news->GetLink() . '#' . $comment->CommentId);
  }
}
