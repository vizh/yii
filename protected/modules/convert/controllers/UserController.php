<?php
class UserController extends convert\components\controllers\Controller
{
  /**
   * Конвертирует пользователей 
   */
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
  
  /**
   * Конвертирует работу пользователя 
   */
  public function actionEmployment()
  {
    $employments = $this->queryAll('SELECT * FROM `UserEmployment` ORDER BY `EmploymentId` ASC');
    foreach ($employments as $employment)
    {
      $newEmployment = new \user\models\Employment();
      $newEmployment->Id = $employment['EmploymentId'];
      $newEmployment->UserId = $employment['UserId'];
      $newEmployment->CompanyId = $employment['CompanyId'];
      $newEmployment->Position = $employment['Position'];
      $newEmployment->Primary = $employment['Primary'] == 1 ? true : false;

      if ($employment['StartWorking'] != '9999-00-00' && $employment['StartWorking'] != '0000-00-00')
      {
        $date = explode('-', $employment['StartWorking']);
        $newEmployment->StartYear = $date[0];
        if ($date[1] != '00')
        {
          $newEmployment->StartMonth = $date[1];
        }
      }
      
      if ($employment['FinishWorking'] != '9999-00-00' && $employment['FinishWorking'] != '0000-00-00')
      {
        $date = explode('-', $employment['FinishWorking']);
        $newEmployment->EndYear = $date[0];
        if ($date[1] != '00')
        {
          $newEmployment->EndMonth = $date[1];
        }
      }
  
      $newEmployment->save();
    }
  }
}
