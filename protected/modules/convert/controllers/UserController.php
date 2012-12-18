<?php
class UserController extends convert\components\controllers\Controller
{
  public function actionIndex()
  {
    $users = $this->queryAll('SELECT * FROM `User` ORDER BY UserId');
    foreach ($users as $user)
    {
      $newUser = new \user\models\User();
      $newUser->Id = $user['Id'];
      $newUser->LastName = $user['LastName'];
      $newUser->FirstName = $user['FirstName'];
      $newUser->FatherName = $user['FatherName'];
      switch ($user['Sex'])
      {
        case 1:
          $newUser->Gender = user\models\Gender::Male;
          break;
        case 2:
          $newUser->Gender = user\models\Gender::Female;
          break;
        default:
          $newUser->Gender = user\models\Gender::None;
          break;
      }
      if ($user['Birthday'] != '0000-00-00')
      {
        $newUser->Birthday = date('Y-m-d H:i:s', $user['Birthday']);
      }
      $newUser->OldPassword = $user['Password'];
      $newUser->Email = $user['Email'];
      $newUser->CreationTime = date('Y-m-d H:i:s', $user['CreationTime']);
      $newUser->UpdateTime = date('Y-m-d H:i:s', $user['UpdateTime']);
      if ($user['LastVisit'] != 0)
      {
        $newUser->LastVisit = date('Y-m-d H:i:s', $user['LastVisit']);
      }
      $newUser->RunetId = $user['RocId'];
      $newUser->save();
    }
  }
}
