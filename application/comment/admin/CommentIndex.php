<?php
AutoLoader::Import('comment.source.*');
AutoLoader::Import('library.rocid.event.*');

class CommentIndex extends AdminCommand
{
  const CommentCount = 50;

  /**
   * Основные действия комманды
   * @param int $page
   * @return void
   */
  protected function doExecute($page = 1)
  {
    $page = intval($page);
    $comments = CommentModel::GetByPage(self::CommentCount, $page);
    $count = CommentModel::$GetByPageCountLast;

    foreach ($comments as $comment)
    {
      $view = new View();
      $view->SetTemplate('comment');
      $view->Comment = $comment;
      if ($comment->ObjectType == CommentModel::ObjectEvent)
      {
        $view->Event = Event::GetById($comment->ObjectId);
      }
      $this->view->Comments .= $view;
    }
    //$url = '/news/category/' . $catName . '/%s/';
    //$this->view->Paginator = new Paginator($url, $page, $perPage, $allCount);

    $this->view->Paginator = new Paginator(RouteRegistry::GetAdminUrl('comment', '', 'index', array('page' => '%s')), $page, self::CommentCount, $count);
    echo $this->view;
  }
}
