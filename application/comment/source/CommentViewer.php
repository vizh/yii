<?php
AutoLoader::Import('library.texts.*');

class CommentViewer
{
  private $objectId;
  private $objectType;

  /**
   * @var User
   */
  private $loginUser;

  /**
   * @param int $objectId
   * @param string $objectType
   */
  public function __construct($objectId, $objectType)
  {
    $this->objectId = intval($objectId);
    $this->objectType = $objectType;

    $this->loginUser = Registry::GetVariable('LoginUser');

    $view = Registry::GetVariable('MainView');
    $view->HeadScript(array('src'=>'/js/comment.js?1.1.2'));
  }

  public function __toString()
  {
    $view = new View();
    $view->SetTemplate('comments', 'comment', 'viewer', '', 'public');

    $view->ObjectId = $this->objectId;
    $view->ObjectType = $this->objectType;
    $view->BackUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    
    $isAdmin = false;
    $view->IsLogin = $this->loginUser != null;
    if ($this->loginUser != null)
    {
      $view->UserPhoto = $this->loginUser->GetMiniPhoto();
      $view->FirstName = $this->loginUser->FirstName;
      $view->LastName = $this->loginUser->LastName;

      $isAdmin = $this->loginUser->IsHaveAdminPermissions();
    }

    $comments = CommentModel::GetByObjectId($this->objectId, $this->objectType);

    $view->Count = sizeof($comments);

    $view->Comments = '';
    $i = 1;
    foreach ($comments as $comment)
    {
      $commentView = new View();
      $commentView->SetTemplate('comment', 'comment', 'viewer', '', 'public');

      if ($i == 1 && $this->objectType != CommentModel::ObjectLunch)
      {
        $commentView->First = true;
      }
      elseif ($i == sizeof($comments) && $this->objectType == CommentModel::ObjectLunch)
      {
        $commentView->First = true;
      }
      else
      {
        $commentView->First = false;
      }

      $commentView->CommentId = $comment->CommentId;
      $commentView->Date = getdate(strtotime($comment->PostDate));
      $commentView->CommentContent = $comment->Content;
      $commentView->UserPhoto = $comment->User->GetMiniPhoto();
      $commentView->FirstName = $comment->User->FirstName;
      $commentView->LastName = $comment->User->LastName;
      $commentView->RocId = $comment->User->RocId;

      $commentView->IsAdmin = $isAdmin;
      $commentView->BackUrl = $view->BackUrl;

      if ($this->objectType == CommentModel::ObjectLunch)
      {
        $view->Comments = $commentView . $view->Comments;
      }
      else
      {
        $view->Comments .= $commentView;
      }
      $i++;
    }

    return $view->__toString();
  }
}
