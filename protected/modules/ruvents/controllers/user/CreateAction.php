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

    foreach ($form->validatorList as $validator)
    {
      if ($validator instanceof \CRequiredValidator)
      {
        foreach ($validator->attributes as $key => $value)
        {
          if ($value === 'Company')
          {
            unset($validator->attributes[$key]);
          }
        }
      }
    }

    if ($form->validate())
    {
      $user = $form->register();
      $this->updateRole($user);

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

  private function updateRole(\user\models\User $user)
  {
    $roleId = (int)\Yii::app()->getRequest()->getParam('RoleId');
    /** @var $role \event\models\Role */
    $role = \event\models\Role::model()->findByPk($roleId);
    if ($role !== null)
    {
      if (sizeof($this->getEvent()->Parts) > 0)
      {
        $partId = (int)\Yii::app()->getRequest()->getParam('PartId');
        /** @var $part \event\models\Part */
        $part = \event\models\Part::model()->findByPk($partId);
        if ($part === null || $part->EventId !== $this->getEvent()->Id)
        {
          throw new \ruvents\components\Exception(306);
        }
        $this->getEvent()->registerUserOnPart($part, $user, $role);
        if ($part !== null)
        {
          $this->getDetailLog()->addChangeMessage(new \ruvents\models\ChangeMessage('Part', $part->Id, $part->Id));
        }
      }
      else
      {
        $this->getEvent()->registerUser($user, $role);
      }
      $this->getDetailLog()->addChangeMessage(new \ruvents\models\ChangeMessage('Role', 0, $role->Id));
    }
  }
}
