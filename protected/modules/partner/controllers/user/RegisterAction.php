<?php
namespace partner\controllers\user;

class RegisterAction extends \partner\components\Action
{
  public function run()
  {
    $this->getController()->setPageTitle('Регистрация нового пользователя');
    $this->getController()->initBottomMenu('register');
    
    $cs = \Yii::app()->clientScript;
    $cs->registerScriptFile(\Yii::app()->getAssetManager()->publish(\Yii::PublicPath() . '/js/libs/jquery-ui-1.8.16.custom.min.js'), \CClientScript::POS_HEAD);
    $blitzerPath = \Yii::app()->getAssetManager()->publish(\Yii::PublicPath() . '/css/blitzer');
    $cs->registerCssFile($blitzerPath . '/jquery-ui-1.8.16.custom.css');
    
    
    $request = \Yii::app()->getRequest();
    $registerForm = new \partner\components\form\UserRegisterForm();
    $registerForm->attributes = $request->getParam(get_class($registerForm));
    if ($request->getIsPostRequest()
      && $registerForm->validate())
    {
      $user = new \user\models\User();
      $user->attributes = $registerForm->attributes;
      $user->Register();
      $user->Settings->Agreement = 1;
      $user->Settings->save();
      
      if (!empty($registerForm->Company))
      {
        $this->addEmployment($user, $registerForm->Company, $registerForm->Position);
      }
      
      if (!empty($registerForm->Phone))
      {
        $phone = new \contact\models\Phone();
        $phone->Phone = $registerForm->Phone;
        $phone->Primary = 1;
        $phone->Type = \contact\models\Phone::TypeMobile;
        $phone->save();
        $user->AddPhone($phone);
      }
      
      if (!empty($registerForm->City))
      {
        $city = \geo\models\City::model()->find('t.Name = :Name', array('Name' => $registerForm->City));
        if ($city != null)
        {
          $address = new \contact\models\Address();
          $address->CityId = $city->CityId;
          $address->save();
          $user->AddAddress($address);
        }
      }
      $this->getController()->redirect(
        $this->getController()->createUrl('user/edit', array('rocId' => $user->RocId))
      );
    }
    $this->getController()->render('register', array('model' => $registerForm));
  }
  
  
  
  
  private function addEmployment ($user, $companyName, $position = '')
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
}