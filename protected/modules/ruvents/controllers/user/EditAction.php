<?php
namespace ruvents\controllers\user;

class EditAction extends \ruvents\components\Action
{

  public function run()
  {
    $request = \Yii::app()->getRequest();
    $runetId = $request->getParam('RunetId', null);

    $user = \user\models\User::model()->byRunetId($runetId)->find();
    if ($user === null)
    {
      throw new \ruvents\components\Exception(202, array($runetId));
    }
    $event = $this->getEvent();

    $participant = \event\models\Participant::model()
        ->byEventId($event->Id)->byUserId($user->Id)->find();
    if ($participant === null)
    {
      throw new \ruvents\components\Exception(304);
    }

    $this->updateMainInfo($user);
    $this->updateEmail($user);
    $this->updatePhone($user);
    $this->updateEmployment($user);
    $this->updateRole($user);

    $this->getDetailLog()->UserId = $user->Id;
    $this->getDetailLog()->save();

    $user->refresh();

    $this->getDataBuilder()->createUser($user);
    $this->getDataBuilder()->buildUserPhone($user);
    $this->getDataBuilder()->buildUserEmployment($user);
    echo json_encode(array('User' => $this->getDataBuilder()->buildUserEvent($user)));
  }

  /**
   * @param \user\models\User $user
   *
   * @throws \ruvents\components\Exception
   */
  private function updateMainInfo(\user\models\User $user)
  {
    $request = \Yii::app()->getRequest();

    $form = new \user\models\forms\edit\Main();
    foreach ($form->getAttributes() as $name => $value)
    {
      //todo: переписать
      if ($name === 'Address')
      {
        continue;
      }
      $newValue = $request->getParam($name, null);
      if ($newValue !== null)
      {
        $this->getDetailLog()->addChangeMessage(new \ruvents\models\ChangeMessage($name, $user->$name, $newValue));
        $form->$name = $newValue;
      }
      else
      {
        $form->$name = $user->$name;
      }
    }

    $form->Birthday = \Yii::app()->dateFormatter->format('dd.MM.yyyy', $form->Birthday);
    if ($form->validate())
    {
      $user->FirstName = $form->FirstName;
      $user->LastName = $form->LastName;
      $user->FatherName = $form->FatherName;
      $user->Gender = $form->Gender;
      $user->Birthday = \Yii::app()->dateFormatter->format('yyyy-MM-dd', $form->Birthday);
      $user->save();
    }
    else
    {
      foreach ($form->getErrors() as $message)
      {
        throw new \ruvents\components\Exception(207, $message);
      }
    }
  }

  private function updateEmail(\user\models\User $user)
  {
    $request = \Yii::app()->getRequest();
    $email = $request->getParam('Email', null);
    $email = strtolower($email);
    if ($user->Email == $email)
    {
      return;
    }
    if ($email !== null)
    {
      $emailValidator = new \CEmailValidator();
      if (!$emailValidator->validateValue($email))
      {
        throw new \ruvents\components\Exception(205);
      }
      $checkUser = \user\models\User::model()->byEmail($email)->byVisible(true)->find();
      if ($checkUser !== null && $checkUser->Id != $user->Id)
      {
        throw new \ruvents\components\Exception(206);
      }
      $this->getDetailLog()->addChangeMessage(new \ruvents\models\ChangeMessage('Email', $user->Email, $email));
      $user->Email = $email;
      $user->save();
    }
  }

  private function updatePhone(\user\models\User $user)
  {
//    $phone = \Yii::app()->getRequest()->getParam('Phone', null);
//    if (!empty($phone))
//    {
//      $user->setContactPhone($phone);
//    }
  }

  private function updateEmployment(\user\models\User $user)
  {
    $request = \Yii::app()->getRequest();

    $company = $request->getParam('Company', null);
    $position = $request->getParam('Position', '');
    $employment = $user->getEmploymentPrimary();
    if ($company !== null)
    {
      if ($employment !== null)
      {
        if ($employment->Company->Name != $company || $employment->Position != $position)
        {
          $this->getDetailLog()->addChangeMessage(new \ruvents\models\ChangeMessage('Company', $employment->Company->Name, $company));
          $this->getDetailLog()->addChangeMessage(new \ruvents\models\ChangeMessage('Position', $employment->Position, $position));
          $user->setEmployment($company, $position);
        }
      }
      else
      {
        $this->getDetailLog()->addChangeMessage(new \ruvents\models\ChangeMessage('Company', '', $company));
        $this->getDetailLog()->addChangeMessage(new \ruvents\models\ChangeMessage('Position', '', $position));
        $user->setEmployment($company, $position);
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
