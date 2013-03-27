<?php
class UserController extends \ruvents\components\Controller
{


  /**
   *
   */
  public function actionCreate ()
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

      $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('LastName', '', $form->LastName));
      $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('FirstName', '', $form->FirstName));
      $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('FatherName', '', $form->FatherName));
      $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('Email', '', $form->Email));
      $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('Company', '', $form->Company));
      $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('Position', '', $form->Position));
      if (!empty($form->Phone))
      {
        $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('Phone', '', $form->Phone));
      }
      $this->detailLog->UserId = $user->UserId;
      $this->detailLog->save();

      $result = array();
      $result['User'] = $this->buildUser($user);
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
  
  /**
   * 
   */
  public function actionEdit ()
  {
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
  
  /**
   *
   * @throws \ruvents\components\Exception 
   */
  public function actionSearch ()
  {
    $request = Yii::app()->getRequest();
    $query = $request->getParam('Query', null);
    $locale = $request->getParam('Locale', \Yii::app()->language);
    if (empty($query))
    {
      throw new \ruvents\components\Exception(501);
    }
    
    $criteriaWith = array(
      'Emails' => array('together' => true), 
      'Phones', 
      'Employments', 
      'Settings' => array('together' => true)
    );
    
    if (filter_var($query, FILTER_VALIDATE_EMAIL))
    {
      $user = \user\models\User::GetByEmail($query, $criteriaWith);
      if ($user === null)
      {
        $criteria = new CDbCriteria();
        $criteria->condition = 'Emails.Email = :Email';
        $criteria->params[':Email'] = $query;
        $criteria->with = $criteriaWith;
        $users = \user\models\User::model()->findAll($criteria);
      }
      else
      {
        $users[] = $user;
      }
    }
    else 
    {
      $userModel = \user\models\User::model()->bySearch($query, $locale);
      $criteria = new CDbCriteria();
      $criteria->with  = $criteriaWith;
      $criteria->limit = 200;
      $users = $userModel->findAll($criteria);
    }
    
    $result = array('Users' => array());
    if (!empty($users))
    {
      foreach ($users as $user)
      {
        $result['Users'][] = $this->buildUser($user);
      }
    }
    echo json_encode($result);
  }
  
  
  /**
   * Строит результат пользователя
   * @param \user\models\User $user
   * @return stdClass 
   */
  private function buildUser ($user)
  {
    $this->DataBuilder()->CreateUser($user);
    $this->DataBuilder()->BuildUserEmail($user);
    $this->DataBuilder()->BuildUserEmployment($user);
    return $this->DataBuilder()->BuildUserPhone($user);
  }
  
  /**
   * Связывает пользователя с местом работы
   * @param \user\models\User $user
   * @param string $companyName
   * @param string $position 
   */
  private function addUserEmployment ($user, $companyName, $position)
  {
    if (!empty($user->Employments))
    {
      foreach ($user->Employments as $userEmployment)
      {
        $userEmployment->Primary = 0;
        $userEmployment->save();
      }
    }
    
    $companyInfo = \company\models\Company::ParseName($companyName);
    $company = \company\models\Company::GetCompanyByName($companyInfo['name']);
    if ($company == null)
    {
      $company = new \company\models\Company();
      $company->Name = $companyInfo['name'];
      $company->Opf = $companyInfo['opf'];
      $company->CreationTime = time();
      $company->UpdateTime = time();
      $company->save();
    }

    $employment = new \user\models\Employment();
    $employment->UserId = $user->UserId;
    $employment->CompanyId = $company->CompanyId;
    $employment->SetParsedStartWorking(array('year' => '9999'));
    $employment->SetParsedFinishWorking(array('year' => '9999'));
    $employment->Position = $position;
    $employment->Primary = 1;
    $employment->save();
  }
  
  /**
   * Добавляет телефон пользователю
   * @param \user\models\User $user
   * @param string $phone
   * @param string $type 
   */
  private function addUserPhone ($user, $phone, $type = \contact\models\Phone::TypeMobile)
  {
    if (!empty($user->Phones))
    {
      foreach ($user->Phones as $userPhone)
      {
        $userPhone->Primary = 0;
        $userPhone->Save();
      }
    }

    $contactPhone = new \contact\models\Phone();
    $contactPhone->Phone = $phone;
    $contactPhone->Primary = 1;
    $contactPhone->Type = \contact\models\Phone::TypeMobile;
    $contactPhone->save();   
    $user->AddPhone($contactPhone);
  }
}
