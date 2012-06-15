<?php
AutoLoader::Import('comment.source.*');
 
class CommentDelete extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($commentId = '')
  {
    $backUrl = Registry::GetRequestVar('backUrl');
    if ($this->LoginUser == null || !$this->LoginUser->IsHaveAdminPermissions())
    {
      Lib::Redirect($backUrl);
    }
    $commentId = intval($commentId);
    $comment = CommentModel::GetById($commentId);
    if ($comment == null)
    {
      Lib::Redirect($backUrl);
    }

    $comment->Deleted = 1;
    $comment->save();

    Lib::Redirect($backUrl);
  }
}
