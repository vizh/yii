<?php
namespace ruvents\controllers\user;

use event\models\Part;
use event\models\Role;
use ruvents\components\Action;
use ruvents\components\Exception;
use ruvents\models\ChangeMessage;
use user\models\forms\RegisterForm;
use user\models\User;

class CreateAction extends Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();

    $form = new RegisterForm(RegisterForm::SCENARIO_RUVENTS);
    $form->LastName = $request->getParam('LastName');
    $form->FirstName = $request->getParam('FirstName');
    $form->FatherName = $request->getParam('FatherName');
    $form->Email = $request->getParam('Email');
    $form->Company = $request->getParam('Company');
    $form->Position = $request->getParam('Position');
    $form->Phone = $request->getParam('Phone');
    $form->Visible = $request->getParam('Visible');

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

    if (!$form->Visible && empty($form->Email))
    {
      $form->Email = 'nomail'.$this->getEvent()->Id.'+'.substr(md5($form->FirstName . $form->LastName . $form->Company), 0, 8).'@runet-id.com';
    }

    if ($form->validate())
    {
      $user = $form->register();
      $this->updateRoles($user);

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
      $result['User'] = $this->getDataBuilder()->buildUserPhone($user);

      $this->renderJson($result);
    }
    else
    {
      foreach ($form->getErrors() as $message)
      {
        throw new Exception(207, $message);
      }
    }
  }

  private function updateRoles(User $user)
  {
    $event = $this->getEvent();
    $statuses = (array) json_decode(\Yii::app()->getRequest()->getParam('Statuses')); if (!$statuses)
      throw new Exception(310);

    foreach ($statuses as $part_id => $role_id)
    {
      $role = Role::model()->findByPk($role_id); if (!$role)
        throw new Exception(302, [$role_id]);

      // Обработка однопартийных мероприятий
      if (!$part_id && count($statuses) === 1)
      {
        $event->registerUser($user, $role);
        $this->getDetailLog()->addChangeMessage(new ChangeMessage('Role', '', $role->Id));
        continue;
      }

      $part = Part::model()->findByPk($part_id); if (!$part || $part->EventId !== $event->Id)
        throw new Exception(306);

      $event->registerUserOnPart($part, $user, $role); if ($part)
      $this->getDetailLog()->addChangeMessage(new ChangeMessage('Role', $part->Id, $role->Id));
    }
  }
}
