<?php
AutoLoader::Import('comment.source.*');

class CommentAdd extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $objectId = Registry::GetRequestVar('objectId');
    $objectId = intval($objectId);
    $objectType = Registry::GetRequestVar('objectType');
    $backUrl = Registry::GetRequestVar('backUrl');

    if ($objectId == 0 || ! in_array($objectType, CommentModel::$ObjectsAll) || $this->LoginUser == null)
    {
      Lib::Redirect($backUrl);
    }

//    $parent = null;
//    if ($parentId != 0)
//    {
//      $parent = NewsComments::GetById($parentId);
//    }

    $commentContent = Registry::GetRequestVar('comment');

    $comment = new CommentModel();
//    if ($parent != null)
//    {
//      $comment->ParentId = $parent->CommentId;
//    }
    $comment->UserId = $this->LoginUser->UserId;
    $comment->PostDate = date('Y-m-d H:i:s', time());
    $comment->ObjectId = $objectId;
    $comment->ObjectType = $objectType;
    $comment->SetContent($commentContent);
    $content = trim($comment->Content);
    if (empty($content))
    {
      Lib::Redirect($backUrl);
    }
    $comment->save();

    Lib::Redirect($backUrl . '#' . $comment->CommentId);    
  }
}
 
