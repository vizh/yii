<?php

use user\models\User;

class AuthController extends \application\components\controllers\AdminMainController
{
    public function actionIndex()
    {
        $request = \Yii::app()->getRequest();
        if ($request->isPostRequest) {
            $runetId = $request->getParam('RunetId');
            $redirectUrl = $request->getParam('RedirectUrl');
            $user = User::model()->byRunetId($runetId)->find();
            if ($user == null) {
                \Yii::app()->user->setFlash('error', \Yii::t('app', 'Пользователь с таким RUNET&ndash;ID не найден.'));
            } else {
                \Yii::app()->user->setFlash('success', \Yii::t(
                    'app',
                    'Ссылка на быструю авторизацию: <strong>{link}</strong><br/><a href="{link}">Авторизоваться</a>',
                    [
                        '{link}' => $user->getFastauthUrl($redirectUrl)
                    ]
                ));
            }
        }
        $this->render('index');
    }
}
