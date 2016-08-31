<?php


class SocialController extends \oauth\components\Controller
{

    /**
     * @throws CException
     * @throws CHttpException
     */

    public function actionRequest()
    {
        $socialProxy = new \oauth\components\social\Proxy($this->social);
        if ($socialProxy->isHasAccess())
        {
            $data = $socialProxy->getData();
            $social = $socialProxy->getSocial($data->Hash);
            if (!empty($social))
            {
                $identity = new \application\components\auth\identity\RunetId($social->User->RunetId);
                $identity->authenticate();
                if ($identity->errorCode == \CUserIdentity::ERROR_NONE)
                {
                    \Yii::app()->user->login($identity, $identity->GetExpire());
                }
                else
                {
                    throw new CHttpException(400);
                }
                $this->redirect($this->createUrl('/oauth/main/dialog',['frame'=>true]));
            }
            else
            {
                $this->redirect($this->createUrl('/oauth/main/register', ['frame'=>true]));
            }
        }
        else
        {
            $this->redirect($socialProxy->getOAuthUrl());
        }
    }

    /**
     * @throws CHttpException
     */

    public function actionConnect()
    {
        $socialProxy = new \oauth\components\social\Proxy($this->social);
        if ($socialProxy->isHasAccess()) // если пользователь авторизован и зареган на сайте
        {
            if (\Iframe::isFrame()) {
                $socialProxy->renderScript();
            }
            else {
                $this->actionRequest();
            }
        }
        else
        {
            $this->redirect($socialProxy->getOAuthUrl());
        }
    }
}