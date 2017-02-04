<?php

use oauth\components\social\Proxy;
use oauth\models\Social;
use user\models\User;

class SocialController extends \oauth\components\Controller
{

    /**
     * @throws CException
     * @throws CHttpException
     */

    public function actionRequest()
    {
        $proxy = new Proxy($this->social);

        if ($proxy->isHasAccess())
        {
            $social = Social::model()
                ->byHash($proxy->getData()->Hash)
                ->bySocialId($proxy->getSocialId())
                ->findAll();

            /**
             * Очень временное решение. РЕШИТЬ ПРОБЛЕМУ
             */
            // Значит есть дубли в таблице OAuthSocial. Ищем реального пользователя
            if(count($social) > 1){
                $uids = [];
                foreach($social as $s){
                    $uids[] = $s->UserId;
                }
                $criteria = new CDbCriteria();
                $criteria->addInCondition('"Id"', $uids);
                $users = User::model()->findAll($criteria);
                $social = $social[0];
                $social->User=$users[0];
            }else{
                $social = $social[0];
            }

            if (!empty($social) && !empty($social->User))
            {
                $identity = new \application\components\auth\identity\RunetId($social->User->RunetId);
                $identity->authenticate();
                if ($identity->errorCode == \CUserIdentity::ERROR_NONE)
                {
                    \Yii::app()->user->login($identity, $identity->getExpire());
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
            $this->redirect($proxy->getOAuthUrl());
        }
    }

    /**
     * @throws CHttpException
     */
    public function actionConnect()
    {
        $socialProxy = new Proxy($this->social);
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