<?php
class AjaxController extends \application\components\controllers\PublicMainController
{
  public function actionSearch($term)
  {
    $results = array();
    $criteria = new \CDbCriteria();
    $criteria->limit = 10;
    $criteria->with = array('Employments.Company');
    /** @var $users \user\models\User[] */
    $users = \user\models\User::model()->bySearch($term)->findAll($criteria);
    foreach ($users as $user)
    {
      $results[] = $this->getUserData($user);
    }
    echo json_encode($results);
  }
  
  public function actionRegister()
  {
    $result = new \stdClass();
    $form = new \user\models\forms\RegisterForm();
    
    $form->attributes = \Yii::app()->request->getParam(get_class($form));
    if ($form->validate())
    {
      $user = new \user\models\User();
      $user->LastName = $form->LastName;
      $user->FirstName = $form->FirstName;
      $user->FatherName = $form->FatherName;
      $user->Email = $form->Email;
      $user->register();
      $user->setEmployment($form->Company, $form->Position);
      $result->success = true;
      $result->user = $this->getUserData($user);      
    }
    else
    {
      $result->success = false;
      $result->errors  = $form->getErrors(); 
    }
    echo json_encode($result);
  }
  
  
  private function getUserData($user)
  {
    $data = new \stdClass();
    $data->RunetId = $data->value = $user->RunetId;
    $data->LastName = $user->LastName;
    $data->FirstName = $user->FirstName;
    $data->FullName = $data->label = $user->getFullName();
    $data->Photo = new \stdClass();
    $data->Photo->Small = $user->getPhoto()->get50px();
    $data->Photo->Medium = $user->getPhoto()->get90px();
    $data->Photo->Large = $user->getPhoto()->get200px();
    if ($user->getEmploymentPrimary() !== null)
    {
      $data->Company = $user->getEmploymentPrimary()->Company->Name;
      $data->Position = trim($user->getEmploymentPrimary()->Position);
    }
    return $data;
  }
}
