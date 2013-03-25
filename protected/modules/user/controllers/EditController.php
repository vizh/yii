<?php
class EditController extends \application\components\controllers\PublicMainController
{
  public function actionIndex()
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
        \Yii::app()->user->setFlash('success', \Yii::t('app', 'Основная информация профиля успешно сохранена!'));
        $this->refresh();
      }
    }
    else
    {
      $form->FirstName  = $user->FirstName;
      $form->LastName   = $user->LastName;
      $form->FatherName = $user->FatherName;
      $form->Gender     = $user->Gender;
      $form->Birthday   = \Yii::app()->dateFormatter->format('dd.MM.yyyy', $user->Birthday);
    }
    
    $this->bodyId = 'user-account';
    $this->setPageTitle(\Yii::t('app','Редактирование профиля'));
    $this->render('index', array('form' => $form));
  }
  
  
  public function actionPhoto()
  {
    $user = \Yii::app()->user->getCurrentUser();
    $request = \Yii::app()->getRequest();
    $form = new \user\models\forms\edit\Photo();
    if ($request->getIsPostRequest())
    {
      $form->attributes = $request->getParam(get_class($form));
      $form->Image = \CUploadedFile::getInstance($form, 'Image');
      if ($form->validate())
      {
        $user->getPhoto()->SavePhoto($form->Image);
        \Yii::app()->user->setFlash('success', \Yii::t('app', 'Фотография профиля успешно сохранена!'));
        $this->refresh();
      }
    }
    $this->bodyId = 'user-account';
    $this->setPageTitle(\Yii::t('app','Редактирование профиля'));
    $this->render('photo', array('form' => $form, 'user' => $user));
  }
  
  public function actionEmployment()
  { 
    $user = \Yii::app()->user->getCurrentUser();
    $request = \Yii::app()->getRequest();
    $form = new \user\models\forms\edit\Employments();
    $form->attributes = $request->getParam(get_class($form));
    if ($request->getIsPostRequest() && $form->validate())
    {
      foreach ($form->Employments as $item)
      {
        if (!empty($item['Id']))
        {
          $employment = \user\models\Employment::model()->byUserId($user->Id)->findByPk($item['Id']);
        }
        else
        {
          $employment = $user->setEmployment($item['Company'], $item['Position']);
        }
        
        if ($employment !== null)
        {
          if ($item['Deleted'] == 1) 
          {
            $employment->delete();
            continue;;
          }
          $employment->StartMonth = $item['StartMonth'];
          $employment->StartYear = $item['StartYear'];
          $employment->EndMonth = isset($item['EndMonth']) ? $item['EndMonth'] : null;
          $employment->EndYear = isset($item['EndYear']) ? $item['EndYear'] : null;
          $employment->Primary = (isset($item['Primary']) && $item['Primary'] == 1) ? true : false;
          $employment->save();
        }
      }
      \Yii::app()->user->setFlash('success', \Yii::t('app', 'Карьера успешно сохранена!'));
      $this->refresh();
    }
    
    $this->bodyId = 'user-account';
    $this->setPageTitle(\Yii::t('app','Редактирование профиля'));
    $this->render('employment', array('user' => $user, 'form' => $form));
  }
}
