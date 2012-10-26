<?php
class UtilityController extends \register\components\Controller 
{
  public function actionAjaxUserSearch($term)
  {
    $users = \user\models\User::GetBySearch($term, 5);
    if (!empty($users))
    {
      foreach ($users as $user)
      {
        $result[] = array(
          'label' => $this->renderPartial('ajaxuseritem', array('user' => $user), true),
          'value' => $user->GetFullName().', RUNET-ID '.$user->RocId,
          'rocid' => $user->RocId
        );
      }
    }
    echo json_encode($result);
  }
}

?>
