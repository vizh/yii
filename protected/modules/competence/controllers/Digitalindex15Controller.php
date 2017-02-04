<?php

use \application\components\controllers\PublicMainController;
use \oauth\components\social\Proxy;
use oauth\components\social\ISocial;
use oauth\models\Social;
use user\models\User;
use application\components\auth\identity\RunetId;

class Digitalindex15Controller extends PublicMainController
{
    public function actionIndex()
    {
        $user = \Yii::app()->getUser()->getCurrentUser();
        if ($user !== null) {
            $this->redirect('/vote/digitalindex15/process');
        }

        if (\Yii::app()->getRequest()->getParam('connect')) {
            $proxy = new Proxy(ISocial::Vkontakte, $this->createAbsoluteUrl('index', ['connect' => true]));
            if ($proxy->isHasAccess()) {
                $user = $this->getUser($proxy);
                $identity = new RunetId($user->RunetId);
                $identity->authenticate();
                if ($identity->errorCode == \CUserIdentity::ERROR_NONE) {
                    \Yii::app()->getUser()->login($identity, $identity->getExpire());
                }
                $this->refresh();
            } else {
                $this->redirect($proxy->getOAuthUrl());
            }
        }



        $this->render('index');
    }

    /**
     * @param Proxy $proxy
     * @return User
     */
    private function getUser(Proxy $proxy)
    {
        $data = $proxy->getData();
        $social = Social::model()
            ->byHash($data->Hash)
            ->bySocialId($proxy->getSocialId())
            ->find();

        if (empty($social)) {
            $user = new User();
            $user->FirstName = $proxy->getData()->FirstName;
            $user->LastName = $proxy->getData()->LastName;
            $email = $proxy->getData()->Email;
            if (empty($email)) {
                $email =  \CText::generateFakeEmail('digitalindex15');
            } else {
                $user->Visible = !User::model()->byEmail($email)->byVisible(true)->exists();
            }
            $user->Email = $email;
            $user->Verified = true;
            $user->register($user->Visible);
            $user->Settings->UnsubscribeAll = false;
            $user->Settings->save();

            $proxy->saveSocialData($user);
        } else {
            $user = $social->User;
        }
        return $user;
    }
}