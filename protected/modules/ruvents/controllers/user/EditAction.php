<?php
namespace ruvents\controllers\user;

class EditAction extends \ruvents\components\Action
{
  public function run()
  {
    //todo: not worked

    throw new \application\components\Exception('Not implement yet');

    $request = Yii::app()->getRequest();
    $rocId = $request->getParam('RunetId', null);

    $event = \event\models\Event::GetById($this->getOperator()->EventId);
    if ($event === null)
    {
      throw new \ruvents\components\Exception(301);
    }

    $criteria = new \CDbCriteria();
    $criteria->with = array('Participants' => array('together' => true), 'Participants.Role');
    $criteria->condition = 't.RocId = :RocId AND Participants.EventId = :EventId';
    $criteria->params[':RocId'] = $rocId;
    $criteria->params[':EventId'] = $event->EventId;
    /** @var $user \user\models\User */
    $user = \user\models\User::model()->find($criteria);
    if ($user === null)
    {
      throw new \ruvents\components\Exception(304);
    }

    $firstName = $request->getParam('FirstName', null);
    if ($firstName !== null)
    {
      $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('FirstName', $user->FirstName, $firstName));
      $user->FirstName = $firstName;
    }

    $lastName = $request->getParam('LastName', null);
    if ($lastName !== null)
    {
      $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('LastName', $user->LastName, $lastName));
      $user->LastName = $lastName;
    }

    $fatherName = $request->getParam('FatherName', null);
    if ($fatherName !== null)
    {
      $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('FatherName', $user->FatherName, $fatherName));
      $user->FatherName = $fatherName;
    }

    $sex = $request->getParam('Sex', null);
    if ($sex !== null)
    {
      $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('Sex', $user->Sex, $sex));
      $user->Sex = $sex;
    }

    $birthday = $request->getParam('Birthday', null);
    if ($birthday !== null)
    {
      $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('Birthday', $user->Birthday, $birthday));
      $user->Birthday = $birthday;
    }

    if ($user->validate())
    {
      $user->UpdateTime = time();
      $user->save();
    }
    else
    {
      foreach ($user->getErrors() as $message)
      {
        throw new \ruvents\components\Exception(207, $message);
      }
    }

    $email = $request->getParam('Email', null);
    if ($email !== null)
    {
      $emailValidator = new \CEmailValidator();
      if (!$emailValidator->validateValue($email))
      {
        throw new \ruvents\components\Exception(205);
      }

      $userEmail = $user->GetEmail();
      if (!empty($userEmail))
      {
        $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('Email', $userEmail->Email, $email));
        $userEmail->Email = $email;
        $userEmail->save();
      }
      else
      {
        $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('Email', '', $email));
        $user->AddEmail($email, 1);
      }
    }

    $phone = $request->getParam('Phone', null);
    if ($phone !== null)
    {
      $flag = true;
      if (!empty($user->Phones))
      {
        foreach ($user->Phones as $userPhone)
        {
          if ($userPhone->Phone == $phone)
          {
            $flag = false;
            break;
          }
        }
      }

      if ($flag)
      {
        $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('Phone', '', $phone));
        $this->addUserPhone($user, $phone);
      }
    }

    $company = $request->getParam('Company', null);
    $position = $request->getParam('Position', '');
    $primaryEmployment = $user->GetPrimaryEmployment();
    if ($company != null)
    {

      $changesInCompany = $primaryEmployment !== null && ($primaryEmployment->Company->Name != $company || $primaryEmployment->Position != $position);

      if ($primaryEmployment === null || $changesInCompany)
      {
        if ($primaryEmployment !== null)
        {
          $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('Company', $primaryEmployment->Company->Name, $company));
          $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('Position', $primaryEmployment->Position, $position));
        }
        else
        {
          $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('Company', '', $company));
          $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('Position', '', $position));
        }
        $this->addUserEmployment($user, $company, $position);
      }
    }

    $this->detailLog->UserId = $user->UserId;
    $this->detailLog->save();

    $result = array();
    $user = \user\models\User::GetByRocid($user->RocId);
    $this->buildUser($user);
    $result['User'] = $this->DataBuilder()->BuildUserEvent($user);
    echo json_encode($result);
  }
}
