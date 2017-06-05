<?php

use application\components\auth\identity\Base;
use application\components\auth\identity\RunetId;
use oauth\models\AccessToken;
use widget\components\Controller;

class AuthController extends Controller
{
    protected $useBootstrap3 = true;

    public function actionIndex($redirectRoute)
    {
        $request = \Yii::app()->getRequest();
        $token = $request->getParam('token');
        $accessToken = AccessToken::model()->byToken($token)->find();
        if ($accessToken !== null) {
            $identity = new RunetId($accessToken->User->RunetId);
            $identity->authenticate();
            if ($identity->errorCode == Base::ERROR_NONE) {
                \Yii::app()->getUser()->login($identity);
                echo '
                    <script type="text/javascript">
                        window.opener.location.reload();
                        window.close();
                    </script>';
                \Yii::app()->end();
            }
        }
        if ($this->getUser() !== null) {
            $this->redirect([$redirectRoute]);
        }
        $this->render('index');
    }
}