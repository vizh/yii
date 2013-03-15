<?php
class AjaxController extends \application\components\controllers\PublicMainController
{
  public function actionSearch($term)
  {
    $results = array();
    $criteria = new \CDbCriteria();
    $users = \user\models\User::model()->bySearch($term)->findAll($criteria);
    foreach ($users as $user)
    {
      $result = new \stdClass();
      $result->RunetId = $user->RunetId;
      $result->LastName = $user->LastName;
      $result->FirstName = $user->FirstName;
      $result->FullName = $user->getFullName();
      $result->Photo = new \stdClass();
      $result->Photo->Small = $user->getPhoto()->get50px();
      $result->Photo->Medium = $user->getPhoto()->get90px();
      $result->Photo->Large = $user->getPhoto()->get200px();
      $result->value = '12312';
      $result->label = 'NTCN';
      $results[] = $result;
    }
    echo json_encode($results);
  }
}
