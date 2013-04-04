<?php
namespace user\controllers\edit;

class ContactsAction extends \CAction
{
  public function run()
  {
    $user = \Yii::app()->user->getCurrentUser();
    $request = \Yii::app()->getRequest();
    $form = new \user\models\forms\edit\Contacts();
    $form->attributes = $request->getParam(get_class($form));
    if ($request->getIsPostRequest())
    {
      if ($form->validate())
      {
        foreach ($form->Accounts as $account)
        {
          $accountType = \contact\models\ServiceType::model()->findByPk($account->TypeId);
          $user->setContactServiceAccount($account->Account, $accountType);
        }
      }
    }
    else
    {
      foreach ($user->LinkPhones as $linkPhone)
      {
        $phone = new \contact\models\forms\Phone();
        $phone->attributes = array(
          'Id' => $linkPhone->PhoneId,
          'CityCode' => $linkPhone->Phone->CityCode,
          'CountryCode' => $linkPhone->Phone->CountryCode,
          'Phone' => $linkPhone->Phone->Phone
        );
        $form->Phones[] = $phone;
      }
      
      foreach ($user->LinkServiceAccounts as $linkAccount)
      {
        $account = new \contact\models\forms\ServiceAccount();
        $account->attributes = array(
          'TypeId' => $linkAccount->ServiceAccount->TypeId,
          'Account' => $linkAccount->ServiceAccount->Account
        );
        $form->Accounts[] = $account;
      }
    }
    $this->getController()->render('contacts', array('form' => $form, 'user' => $user));
  }
}
