<?php
namespace ruvents\controllers\user;

class CreateAction extends \ruvents\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();

    $form = new \user\models\forms\RegisterForm();
    $form->LastName = $request->getParam('LastName');
    $form->FirstName = $request->getParam('FirstName');
    $form->FatherName = $request->getParam('FatherName');
    $form->Email = $request->getParam('Email');
    $form->Company = $request->getParam('Company');
    $form->Position = $request->getParam('Position');
    $form->Phone = $request->getParam('Phone');

    if ($form->validate())
    {
      $user = $form->register();

      $this->getDetailLog()->addChangeMessage(new \ruvents\models\ChangeMessage('LastName', '', $form->LastName));
      $this->getDetailLog()->addChangeMessage(new \ruvents\models\ChangeMessage('FirstName', '', $form->FirstName));
      $this->getDetailLog()->addChangeMessage(new \ruvents\models\ChangeMessage('FatherName', '', $form->FatherName));
      $this->getDetailLog()->addChangeMessage(new \ruvents\models\ChangeMessage('Email', '', $form->Email));
      $this->getDetailLog()->addChangeMessage(new \ruvents\models\ChangeMessage('Company', '', $form->Company));
      $this->getDetailLog()->addChangeMessage(new \ruvents\models\ChangeMessage('Position', '', $form->Position));
      if (!empty($form->Phone))
      {
        $this->getDetailLog()->addChangeMessage(new \ruvents\models\ChangeMessage('Phone', '', $form->Phone));
      }
      $this->getDetailLog()->UserId = $user->Id;
      $this->getDetailLog()->save();

      $result = array();
      $this->getDataBuilder()->createUser($user);
      $this->getDataBuilder()->buildUserEmail($user);
      $this->getDataBuilder()->buildUserEmployment($user);
      $result['User'] =  $this->getDataBuilder()->buildUserPhone($user);

      echo json_encode($result);
    }
    else
    {
      foreach ($form->getErrors() as $message)
      {
        throw new \ruvents\components\Exception(207, $message);
      }
    }
  }
}
