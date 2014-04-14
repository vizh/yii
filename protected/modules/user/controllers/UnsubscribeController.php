<?php
class UnsubscribeController extends \application\components\controllers\PublicMainController
{
  public function actionIndex($email, $hash)
  {
    $user = \user\models\User::model()->byEmail($email)->find();
    if ($user == null || $user->getHash() != $hash)
    {
      throw new \CHttpException(500, \Yii::t('app', 'Не найден пользователь'));
    }
    $user->Settings->UnsubscribeAll = true;
    $user->Settings->save();
    $this->setPageTitle(\Yii::t('app', 'Подписка успешно отменена'));
    $this->render('index');
  }
} 