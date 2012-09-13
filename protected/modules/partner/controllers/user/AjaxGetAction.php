<?php
namespace partner\controllers\user;

class AjaxGetAction extends \partner\components\Action
{
  public function run()
  {
    $name = \Yii::app()->request->getParam('term');
    $users = \user\models\User::GetBySearch($name, 10);
    $result = array();
    foreach ($users as $user)
    {
      $result[] = array('id' => $user->RocId, 'label' => $user->GetFullName());
    }
    echo json_encode($result);
  }
}