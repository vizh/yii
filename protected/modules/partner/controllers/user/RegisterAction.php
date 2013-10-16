<?php
namespace partner\controllers\user;

class RegisterAction extends \partner\components\Action
{
  public function run()
  {
    $this->getController()->setPageTitle('Регистрация нового пользователя');
    $this->getController()->initActiveBottomMenu('register');

    $cs = \Yii::app()->getClientScript();
    $cs->registerPackage('runetid.jquery.ui');

    $request = \Yii::app()->getRequest();
    $form = new \partner\models\forms\user\Register();
    $form->attributes = $request->getParam(get_class($form));
    $user = null;
    if ($request->getIsPostRequest() && $form->validate())
    {
      $hidden = !empty($form->Hidden);
      $notify = !$hidden;

      $user = new \user\models\User();
      $user->LastName = $form->LastName;
      $user->FirstName = $form->FirstName;
      $user->FatherName = $form->FatherName;
      if (empty($form->Email))
      {
        $form->Email = $this->getRandomEmail();
        $notify = false;
      }
      $user->Email = $form->Email;
      $user->register($notify);
      if ($hidden)
      {
        $user->Visible = false;
        $user->save();
      }
      
      if (!empty($form->Company))
      {
        $user->setEmployment($form->Company, $form->Position);

      }
      
      if (!empty($form->Phone))
      {
        $user->setContactPhone($form->Phone);
      }
      
      if (!empty($form->City))
      {
        $city = \geo\models\City::model()->find('"t"."Name" = :Name', ['Name' => $form->City]);
        if ($city != null)
        {
          $address = new \contact\models\Address();
          $address->CityId = $city->Id;
          $address->CountryId = $city->CountryId;
          $address->RegionId = $city->RegionId;
          $address->save();
          $user->setContactAddress($address);
        }
      }

      if (!empty($form->Role))
      {
        $this->getEvent()->skipOnRegister = !$notify;
        $this->getEvent()->registerUser($user, \event\models\Role::model()->findByPk($form->Role));
      }
      $form = new \partner\models\forms\user\Register();
    }
    $this->getController()->render('register', ['form' => $form, 'user' => $user]);
  }

  public function getRandomEmail()
  {
    return 'nomail'.$this->getEvent()->Id.'+'.substr(md5(microtime()), 0, 8).'@runet-id.com';
  }
}