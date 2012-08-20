<?php
class UserController extends \ruvents\components\Controller
{
  public function actionCreate ()
  {
    $request = \Yii::app()->getRequest();
    
    $userModel = new \user\models\User();
    $userModel->LastName = $request->getParam('LastName');
    $userModel->FirstName = $request->getParam('FirstName');
    $userModel->FatherName = $request->getParam('FatherName');
    $userModel->Email = $request->getParam('Email');
    $userModel->Password = $request->getParam('Password');
    if ($userModel->validate())
    {
      $user = $userModel->Register();     
      $user->Settings->Agreement = 1;
      $user->Settings->save();
      
      $companyName = $request->getParam('Company', null);
      $position = $request->getParam('Position', null);
      if ($companyName != null && $position != null)
      {
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
      
      $phone = $request->getParam('Phone', null);
      if ($phone != null)
      {
        $contactPhone = new \contact\models\Phone();
        $contactPhone->Phone = $phone;
        $contactPhone->Primary = 1;
        $contactPhone->Type = \contact\models\Phone::TypeMobile;
        $contactPhone->save();
        
        $user->addPhone($contactPhone);
      }
      
      $result = array();
      $this->DataBuilder()->CreateUser($user);
      $this->DataBuilder()->BuildUserEmail($user);
      $result['User'] = $this->DataBuilder()->BuildUserEmployment($user);
      
      echo json_encode($result);
    }
    else 
    {
      foreach ($userModel->getErrors() as $message)
      {
        throw new \ruvents\components\Exception(207, $message);
      }
    }
  }
}
