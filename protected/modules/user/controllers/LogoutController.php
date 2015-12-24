<?php

class LogoutController extends \application\components\controllers\PublicMainController
{
    public function actionIndex($redirectUrl = '')
    {
        $user = \Yii::app()->getUser();
        if (!$user->getIsGuest()) {
            $user->logout();
        }

        if (strpos($redirectUrl, '/') !== false) {
            $parts = parse_url($redirectUrl);
            if (empty($parts['host']) || strstr($parts['host'], RUNETID_HOST) !== false) {
                $this->redirect($redirectUrl);
            }
        }
        $this->redirect(['/main/default/index']);
    }
}
