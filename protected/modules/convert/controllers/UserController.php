<?php
class UserController extends \application\components\controllers\PublicMainController
{
  private $limit = 10;
  
  public function actionIndex()
  {
    $step = \Yii::app()->request->getParam('step', 0);
    $offset = $this->limit * $step;
    
    $connection = \Yii::app()->dbOld;
    $command = $connection->createCommand($sql);
    $command->Text = 'SELECT * FROM `User` ORDER BY UserId LIMIT '.$offset.','.$this->limit;
    $users = $command->queryAll();
    if (!empty($users))
    {
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
        $newUser->Birthday =  $user['Birthday'];
        $newUser->OldPassword = $user['Password'];
        $newUser->Email = $user['Email'];
        $newUser->CreationTime = date('Y-m-d H:i:s', $user['CreationTime']);
        $newUser->UpdateTime = date('Y-m-d H:i:s', $user['UpdateTime']);
        $newUser->LastVisit = date('Y-m-d H:i:s', $user['LastVisit']);
        $newUser->RunetId = $user['RocId'];
        $newUser->save();
      }
    }
    else
    {
      echo 'OK!';
    }
  }
}
