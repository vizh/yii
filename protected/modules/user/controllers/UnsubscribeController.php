<?php

class UnsubscribeController extends \application\components\controllers\PublicMainController
{
  public function actionIndex($email, $hash)
  {
    $user = \user\models\User::model()->byEmail($email)->byVisible(true)->find();
    if ($user == null)
      throw new CHttpException(500, 'Не найден пользователь с email: ' . $email);
    if ($user->getHash() != $hash)
      throw new \CHttpException(500, 'Не корректный код отписки пользователя. Пришедший код: ' . $hash . ' RUNET-ID пользователя: ' . $user->RunetId);
    $user->Settings->UnsubscribeAll = true;
    $user->Settings->save();
    $this->setPageTitle(\Yii::t('app', 'Подписка успешно отменена'));
    $this->render('index');
  }
}
