<?php
class SettingController extends \application\components\controllers\PublicMainController
{
  public function actionPassword()
  {
    $user = \Yii::app()->user->getCurrentUser();
    $request = \Yii::app()->getRequest();
    $form = new \user\models\forms\setting\Password();
    $form->attributes = $request->getParam(get_class($form));
    if ($request->getIsPostRequest() && $form->validate())
    {
      if ($form->NewPassword1 !== $form->NewPassword2)
      {
        $form->addError('NewPassword1', \Yii::t('app', 'Введенные Вами пароли не совпадают!'));
      }
      else if ($user->checkLogin($form->OldPassword) == false)
      {
        $form->addError('OldPassword', \Yii::t('app', 'Неверно указан старый пароль!'));
      }
      else 
      {
        $user->changePassword($form->NewPassword1);
        \Yii::app()->user->setFlash('success', \Yii::t('app', 'Новый пароль успешно сохранен!'));
        $this->refresh();
      }
    }
    
    $this->bodyId = 'user-account';
    $this->setPageTitle(\Yii::t('app', 'Редактирование профиля'));
    $this->render('password', array('form' => $form));
  }
}
