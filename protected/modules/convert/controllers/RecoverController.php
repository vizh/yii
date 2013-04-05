<?php
class RecoverController extends \convert\components\controllers\Controller
{
  public function actionEmployment()
  {
    $employments = $this->queryAll('SELECT * FROM `UserEmployment` WHERE `UserEmployment`.`Primary` = 1 ORDER BY `UserEmployment`.`EmploymentId` ASC');
    foreach ($employments as $employment)
    {
      $newEmployment = \user\models\Employment::model()->byUserId($employment['UserId'])->findByPk($employment['EmploymentId']);
      if ($newEmployment !== null)
      {
        $newEmployment->Primary = true;
        $newEmployment->save();
      }
    }
  }
}
