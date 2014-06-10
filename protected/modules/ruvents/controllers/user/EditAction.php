<?php
namespace ruvents\controllers\user;

use event\models\Part;
use event\models\Participant;
use event\models\Role;
use ruvents\components\Exception;
use ruvents\models\ChangeMessage;
use user\models\User;

class EditAction extends \ruvents\components\Action
{

  public function run()
  {
    $request = \Yii::app()->getRequest();
    $runetId = $request->getParam('RunetId', null);
    $email = $request->getParam('Email', null);

    $user = User::model()->byRunetId($runetId)->find(); if (!$user)
      throw new Exception(202, array($runetId));

    $event = $this->getEvent();

    $participant = Participant::model()
        ->byEventId($event->Id)
        ->byUserId($user->Id)
        ->find();

    if (!$participant)
      throw new Exception(304);

    $this->updateMainInfo($user);
    $this->updatePhone($user);
    $this->updateEmployment($user);
    $this->updateRoles($user);

    // Позволим редактировать посетителей без указания Email. Но только в случае когда он уже есть.
    if ($email || !$user->Email)
      $this->updateEmail($user);

    $this->getDetailLog()->UserId = $user->Id;
    $this->getDetailLog()->save();

    $user->refresh();

    $this->getDataBuilder()->createUser($user);
    $this->getDataBuilder()->buildUserPhone($user);
    $this->getDataBuilder()->buildUserEmployment($user);
    echo json_encode(array('User' => $this->getDataBuilder()->buildUserEvent($user)));
  }

  /**
   * @param User $user
   *
   * @throws Exception
   */
  private function updateMainInfo(User $user)
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
      if ($newValue !== null && $user->$name != $newValue)
      {
        $this->getDetailLog()->addChangeMessage(new ChangeMessage($name, $user->$name, $newValue));
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
        throw new Exception(207, $message);
      }
    }
  }

  private function updateEmail(User $user)
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
        throw new Exception(205);
      }
      $checkUser = User::model()->byEmail($email)->byVisible(true)->find();
      if ($checkUser !== null && $checkUser->Id != $user->Id)
      {
        throw new Exception(206);
      }
      $this->getDetailLog()->addChangeMessage(new ChangeMessage('Email', $user->Email, $email));
      $user->Email = $email;
      $user->save();
    }
  }

  private function updatePhone(User $user)
  {
    $phone = \Yii::app()->getRequest()->getParam('Phone', null);
    if (!empty($phone))
    {
      $user->setContactPhone($phone);
    }
  }

  private function updateEmployment(User $user)
  {
    $request = \Yii::app()->getRequest();

    $company = $request->getParam('Company', null);
    $position = $request->getParam('Position', '');
    $employment = $user->getEmploymentPrimary();

    if ($employment)
    {
      // Удаление привязки к компании путём очистки поля "Компания" в клиенте?
      if (!$company)
        $company = 'не указана';

      // Ничего не поменялось?
      if ($employment->Company->Name == $company && $employment->Position == $position)
        return;

      $currentCompany = $employment->Company->Name;
      $currentPosition = $employment->Position;
    }

    else
    {
      // Данных о трудоустройстве не было и не будет?
      if (!$company && !$position)
        return;

      $currentCompany = '';
      $currentPosition = '';
    }

    $this->getDetailLog()->addChangeMessage(new ChangeMessage('Company', $currentCompany, $company));
    $this->getDetailLog()->addChangeMessage(new ChangeMessage('Position', $currentPosition, $position));
    $user->setEmployment($company, $position);
  }

  private function updateRoles(User $user)
  {
    $event = $this->getEvent();
    $statuses = (array) json_decode(\Yii::app()->getRequest()->getParam('Statuses'));

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
