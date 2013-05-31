<?php
namespace partner\controllers\user;

class TranslateAction extends \partner\components\Action
{
  public function run($runetId)
  {
    $user = \user\models\User::model()
      ->byRunetId($runetId)->byEventId($this->getEvent()->Id)->find();    
    if ($user == null)
    {
      throw new \CHttpException(404);
    }
    
    $employment = $user->getEmploymentPrimary();
    $locales = \Yii::app()->params['Languages'];
    
    $forms = new \stdClass();
    foreach ($locales as $locale)
    {
      $forms->$locale = new \partner\models\forms\user\Translate();
    }
    
    $request = \Yii::app()->getRequest();
    if ($request->getIsPostRequest())
    {
      $valid = true;
      $translate = $request->getParam('Translate');
      foreach ($locales as $locale)
      {
        $forms->$locale->attributes = $translate[$locale];
        if ($forms->$locale->validate())
        {
          $user->setLocale($locale);
          $user->FirstName  = $forms->$locale->FirstName;
          $user->LastName   = $forms->$locale->LastName;
          $user->FatherName = $forms->$locale->FatherName;
          if ($employment !== null)
          {
            $employment->Company->setLocale($locale);
            $employment->Company->Name = $forms->$locale->Company;
          }
        }
        else
        {
          $valid = false;
        }
        
        if ($valid)
        {
          $user->save();
          if ($employment !== null)
          {
            $employment->Company->save();
          }
          \Yii::app()->user->setFlash('success', \Yii::t('app', 'Персональные данные пользователя успешно сохранены'));
          $this->getController()->refresh();
        }
      }
    }
    else
    {
      foreach ($locales as $locale)
      {
        $user->setLocale($locale);
        $forms->$locale->FirstName  = $user->FirstName;
        $forms->$locale->LastName   = $user->LastName;
        $forms->$locale->FatherName = $user->FatherName;
        if ($employment !== null)
        {
          $employment->Company->setLocale($locale);
          $forms->$locale->Company = $employment->Company->Name;
        }
      }
    }
    $user->resetLocale();
    
    $this->getController()->setPageTitle(\Yii::t('app', 'Редактирование персональных данных'));
    $this->getController()->render('translate', array('forms' => $forms, 'locales' => $locales, 'user' => $user));
  }
}
