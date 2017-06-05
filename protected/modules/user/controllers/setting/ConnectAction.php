<?php
namespace user\controllers\setting;

class ConnectAction extends \CAction
{
    public function run()
    {
        //\YIi::app()->getSession()->remove('google_access_token');

        $user = \Yii::app()->user->getCurrentUser();

        $request = \Yii::app()->getRequest();
        $action = $request->getParam('action');
        if ($action !== null) {
            $social = $request->getParam('social');
            switch ($action) {
                case 'connect':
                    $redirectUrl = $this->getController()->createAbsoluteUrl('/user/setting/connect/', ['action' => $action, 'social' => $social]);
                    $socialProxy = new \oauth\components\social\Proxy($social, $redirectUrl);
                    if ($socialProxy->isHasAccess()) {
                        $socialProxy->renderScript();
                        $socialProxy->saveSocialData($user);
                    } else {
                        $this->getController()->redirect($socialProxy->getOAuthUrl());
                    }
                    break;

                case 'disconnect':
                    $oauthSocialConnect = \oauth\models\Social::model()
                        ->byUserId($user->Id)->bySocialId($social)->find();
                    if ($oauthSocialConnect !== null) {
                        $oauthSocialConnect->delete();
                    }
                    $this->getController()->redirect(
                        $this->getController()->createUrl('/user/setting/connect/')
                    );
                    break;
            }
        }

        $connects = [
            \oauth\components\social\ISocial::Facebook => null,
            \oauth\components\social\ISocial::Vkontakte => null,
            \oauth\components\social\ISocial::Twitter => null,
            \oauth\components\social\ISocial::Google => null,
            \oauth\components\social\ISocial::PayPal => null,
            \oauth\components\social\ISocial::Linkedin => null
        ];

        $oauthSocialConnects = \oauth\models\Social::model()->byUserId($user->Id)->findAll();
        foreach ($oauthSocialConnects as $oauthSocialConnect) {
            $connects[$oauthSocialConnect->SocialId] = $oauthSocialConnect;
        }

        \Yii::app()->getClientScript()->registerScriptFile(
            \Yii::app()->getAssetManager()->publish(
                \Yii::getPathOfAlias('oauth.assets.js').DIRECTORY_SEPARATOR.'module.js'
            )
        );
        $this->getController()->bodyId = 'user-account';
        $this->getController()->setPageTitle(\Yii::t('app', 'Привязка к социальным сетям'));
        $this->getController()->render('connect', ['connects' => $connects]);
    }
}
