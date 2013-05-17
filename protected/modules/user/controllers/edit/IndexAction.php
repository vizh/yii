<?php
namespace user\controllers\edit;
class IndexAction extends \CAction
{
  public function run()
  {
    $user = \Yii::app()->user->getCurrentUser();
    $request = \Yii::app()->getRequest();
    $form = new \user\models\forms\edit\Main();
    if ($request->getIsPostRequest())
    {
      $form->attributes = $request->getParam(get_class($form));
      if ($form->validate())
      {
        $user->FirstName  = $form->FirstName;
        $user->LastName   = $form->LastName;
        $user->FatherName = $form->FatherName;
        $user->Gender     = $form->Gender;
        $user->Birthday   = \Yii::app()->dateFormatter->format('yyyy-MM-dd', $form->Birthday);
        $user->save();
        
        $address = $user->getContactAddress();
        if (!$form->Address->getIsEmpty() || $address !== null)
        {
          if ($address == null)
          {
            $address = new \contact\models\Address();
          }
          $address->RegionId = $form->Address->RegionId;
          $address->CountryId = $form->Address->CountryId;
          $address->CityId = $form->Address->CityId;
          $address->save();
          $user->setContactAddress($address);
        }
        
        \Yii::app()->user->setFlash('success', \Yii::t('app', 'Основная информация профиля успешно сохранена!'));
        $this->getController()->refresh();
      }
    }
    else
    {
      $form->FirstName  = $user->FirstName;
      $form->LastName   = $user->LastName;
      $form->FatherName = $user->FatherName;
      $form->Gender     = $user->Gender;
      $form->Birthday   = \Yii::app()->dateFormatter->format('dd.MM.yyyy', $user->Birthday);
      if ($user->getContactAddress() !== null)
      {
        $form->Address->attributes = $user->getContactAddress()->attributes;
      }
    }
    
    $this->getController()->bodyId = 'user-account';
    $this->getController()->setPageTitle(\Yii::t('app','Редактирование профиля'));
    $this->getController()->render('index', array('form' => $form));
  }
}
