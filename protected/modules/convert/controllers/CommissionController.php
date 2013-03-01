<?php
class CommissionController extends convert\components\controllers\Controller
{
  /**
   * Комиссии
   */
  public function actionIndex()
  {
    $commisions = $this->queryAll('SELECT * FROM `Mod_Comission` ORDER BY `Mod_Comission`.`ComissionId` ASC');
    foreach ($commisions as $commission)
    {
      $newCommission = new \commission\models\Commission();
      $newCommission->Id = $commission['ComissionId'];
      $newCommission->Title = $commission['Title'];
      $newCommission->Description = $commission['Description'];
      $newCommission->Url = $commission['Url'];
      $newCommission->CreationTime = date('Y-m-d H:i:s', $commission['CreationTime']);
      $newCommission->Deleted = $commission['Deleted'] == 1 ? true : false;
      $newCommission->save();
    }
  }
  
  /**
   * Пользователи
   */
  public function actionUser()
  {
    $users = $this->queryAll('SELECT * FROM `Mod_ComissionUser` ORDER BY `Mod_ComissionUser`.`ComissionUserId` ASC');
    foreach ($users as $user)
    {
      $newUser = new \commission\models\User();
      $newUser->Id = $user['ComissionUserId'];
      $newUser->CommissionId = $user['ComissionId'];
      $newUser->UserId = $user['UserId'];
      $newUser->RoleId = $user['RoleId'];
      $newUser->JoinTime = $user['JoinTime'];
      $newUser->ExitTime = $user['ExitTime'];
      $newUser->save();
    }
  }
  
  /**
   * Роли
   */
  public function actionRole()
  {
    $roles = $this->queryAll('SELECT * FROM `Mod_ComissionRole` ORDER BY `Mod_ComissionRole`.`RoleId` ASC');
    foreach ($roles as $role)
    {
      $newRole = new \commission\models\Role();
      $newRole->Id = $role['RoleId'];
      $newRole->Title = $role['Name'];
      $newRole->Priority = $role['Priority'];
      $newRole->save();
    }
  }
  
  /**
   * Проекты
   */
  public function actionProject()
  {
    $projects = $this->queryAll('SELECT * FROM `Mod_ComissionProject` ORDER BY `Mod_ComissionProject`.`Id` ASC');
    foreach ($projects as $project)
    {
      $newProject = new \commission\models\Project();
      $newProject->Id = $project['Id'];
      $newProject->CommissionId = $project['ComissionId'];
      $newProject->Title = $project['Title'];
      $newProject->Description = $project['Description'];
      $newProject->Visible = $project['Visible'] == 1 ? true : false;
      $newProject->save();
    }
  }
  
  /**
   * Пользователи проектов
   */
  public function actionProjectuser()
  {
    $users = $this->queryAll('SELECT * FROM `Mod_ComissionProjectUser` ORDER BY `Mod_ComissionProjectUser`.`Id` ASC');
    foreach ($users as $user)
    {
      $newUser = new \commission\models\ProjectUser();
      $newUser->Id = $user['Id'];
      $newUser->ProjectId = $user['ProjectId'];
      $newUser->UserId = $user['UserId'];
      $newUser->save();
    }
  }
}
