<?php
class AuthController extends \application\components\controllers\AdminMainController
{
  public function actionIndex()
  {
    $request = \Yii::app()->getRequest();
    if ($request->getIsPostRequest())
    {
      $runetId = $request->getParam('RunetId');
      $user = \user\models\User::model()->byRunetId($runetId)->find();
      if ($user == null)
      {
        \Yii::app()->user->setFlash('error', \Yii::t('app', 'Пользователь с таким RUNET&ndash;ID не найден.'));
      }
      else
      {
        \Yii::app()->user->setFlash('success', \Yii::t('app', 'Ссылка на быструю авторизацию: <strong>{link}</strong><br/><a href="{link}">Авторизоваться</a>', array('{link}' =>  $user->getFastauthUrl())));
      }
    }
    $this->render('index');
  }
}
