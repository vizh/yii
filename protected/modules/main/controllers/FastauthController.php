<?php

use application\components\auth\identity\RunetId;
use application\components\controllers\PublicMainController;
use main\models\ShortUrl;
use user\models\User;

/**
 * Class FastauthController Allows to use fast authorisation for users
 */
class FastauthController extends PublicMainController
{
    /**
     * @param int $runetId RunetId identifier for the user
     * @param string $hash Hash
     * @param string $redirectUrl Redirect url where
     * @param bool|false $temporary
     * @throws CException
     * @throws CHttpException
     */
    public function actionIndex($runetId, $hash, $redirectUrl = '', $temporary = false)
    {
        $user = User::model()->byRunetId($runetId)->find();
        if (!$user || $user->getHash($temporary) != $hash) {
            throw new CHttpException(404);
        }

        $identity = new RunetId($user->RunetId);
        $identity->authenticate();
        if ($identity->errorCode == \CUserIdentity::ERROR_NONE) {
            if (!$user->Temporary && !$temporary) {
                \Yii::app()->user->login($identity);
            } else {
                if (!\Yii::app()->user->isGuest) {
                    \Yii::app()->user->logout();
                }

                \Yii::app()->tempUser->login($identity);
            }

            $this->redirectAfter($redirectUrl);
        } else {
            throw new CHttpException(404);
        }
    }

    /**
     * Выполняет редирект после авторизации пользователя
     * @param $url
     */
    private function redirectAfter($url)
    {
        if (!empty($url)) {
            if (strpos($url, '/') !== false) {
                $parts = parse_url($url);
                if (empty($parts['host']) || strstr($parts['host'], RUNETID_HOST) !== false) {
                    $this->redirect($url);
                }
            } else {
                $shortUrl = ShortUrl::model()->byHash($url)->find();
                if ($shortUrl !== null) {
                    $this->redirect($shortUrl->Url);
                }
            }
        }
        $this->redirect(['/main/default/index']);
    }
}
