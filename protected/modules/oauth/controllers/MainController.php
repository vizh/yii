<?php
use api\models\Account;
use application\components\auth\identity\Password;
use application\components\auth\identity\RunetId;
use application\components\Exception;
use mail\components\mailers\SESMailer;
use oauth\components\form\AuthForm;
use oauth\components\social\Proxy;
use oauth\models\AccessToken;
use oauth\models\forms\Register as FormRegister;
use oauth\models\Permission;
use sms\components\gates\SmsRu;
use user\components\handlers\recover\mail\Recover as MailRecover;
use user\components\handlers\recover\sms\Recover as SmsRecover;
use user\models\forms\Recovery;
use user\models\Log;
use user\models\User;

class MainController extends \oauth\components\Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'setpassword' => '\oauth\controllers\main\SetPasswordAction',
            'autocomplete' => '\pay\controllers\admin\order\AutocompleteAction',
            'captcha' => [
                'class' => 'CCaptchaAction',
            ]
        ];
    }

    /**
     * @return mixed
     *
     * Редиректит на главную страницу если не во фрейме
     * или закрывает окно фрэйма
     */

    public function actionDialog()
    {
        if ($this->Account->Id === Account::SELF_ID) {

            /* Происходит мобильная авторизация? */
            $isMobile = Yii::app()->getRequest()->getParam('mobile') === 'true';

            if (!Yii::app()->user->isGuest) {
                Yii::app()->user->setIsRecentlyLogin();
            }

            if (!\Iframe::isFrame() && !$isMobile && !Yii::app()->user->getIsRecentlyLogin()) {
                $this->redirect('/');
            }

            if (empty($this->url)) {
                echo '
                    <script>
                        if(typeof window.top.modalAuthObj=="undefined"){
                            window.opener.top.modalAuthObj.success();
                            window.close();
                        }
                        else
                            window.top.modalAuthObj.success();
                    </script>';
                return;
            } else {
                $this->redirect($this->url);
            }
        }

        $user = Yii::app()->user->getCurrentUser();
        if ($user === null) {
            $this->redirect($this->createUrl('/oauth/main/auth'));
        }

        $permission = Permission::model()->byUserId($user->Id)->byAccountId($this->Account->Id)->find();
        if ($permission !== null) {
            $this->redirectWithToken();
        } elseif (Yii::app()->getRequest()->isPostRequest) {
            $permission = new Permission();
            $permission->UserId = $user->Id;
            $permission->AccountId = $this->Account->Id;
            $permission->Verified = true;
            $permission->save();
            $this->redirectWithToken();
        }

        $this->render('dialog', ['user' => $user, 'event' => $this->Account->Event]);
    }

    private function redirectWithToken()
    {
        $user = Yii::app()->user->getCurrentUser();
        $accessToken = new AccessToken();
        $accessToken->UserId = $user->Id;
        $accessToken->AccountId = $this->Account->Id;
        $accessToken->EndingTime = date('Y-m-d H:i:s', time() + 86400);
        $accessToken->createToken($this->Account);
        $accessToken->save();

        $urlParts = parse_url($this->url);
        $redirectUrl = $urlParts['scheme'].'://'.$urlParts['host'].(!empty($urlParts['path']) ? $urlParts['path'] : '');
        $redirectUrl .= '?'.(!empty($urlParts['query']) ? $urlParts['query'].'&' : '').'token='.$accessToken->Token;
        if (!empty($urlParts['fragment'])) {
            $redirectUrl .= '#'.$urlParts['fragment'];
        }
        $this->redirect($redirectUrl);
    }

    public function actionAuth()
    {
        if (!Yii::app()->user->isGuest) {
            $this->redirect($this->createUrl('/oauth/main/dialog'));
        }

        $fast = $this->fast;
        $this->fast = null;

        $socialProxy = !empty($this->social)
            ? new Proxy($this->social)
            : null;

        $request = Yii::app()->getRequest();
        $authForm = new AuthForm();
        $authForm->attributes = $request->getParam(get_class($authForm));
        if ($request->getIsPostRequest() && $authForm->validate()) {
            $identity = new Password($authForm->Login, $authForm->Password);
            $identity->authenticate();
            if ($identity->errorCode === Password::ERROR_NONE) {
                Yii::app()->getUser()->login($identity, (bool)$authForm->RememberMe ? $identity->getExpire() : 0);
                Log::create(Yii::app()->user->getCurrentUser());
                if (isset($socialProxy) && $socialProxy->isHasAccess()) {
                    $socialProxy->saveSocialData(Yii::app()->user->getCurrentUser());
                }
                // Необходимо, сообщить диалогу авторизации о том, что вызов идёт с веб-приложения
                $params = [];
                if ($request->getParam('mobile') === 'true') {
                    $params['mobile'] = 'true';
                }
                // Успешная авторизация
                $this->redirect($this->createUrl('/oauth/main/dialog', $params));
            } else {
                $authForm->addError('Login', 'Пользователя с такими Эл. почтой или RUNET-ID и паролем не существует.');
            }
        }

        $this->render('auth', [
            'model' => $authForm,
            'socialProxy' => $socialProxy,
            'fast' => $fast
        ]);
    }

    /**
     * Регистрация пользователей
     * @throws Exception
     */
    public function actionRegister()
    {
        if (!Yii::app()->getUser()->getIsGuest()) {
            $this->redirect(['dialog']);
        }

        $form = new FormRegister($this->social);
        $form->fillFromSocialProxy();

        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $form->fillFromPost();
            if ($form->createActiveRecord() !== null) {
                $url = ['dialog'];
                if (Iframe::isFrame()) {
                    $url['frame'] = 'true';
                }
                $this->redirect($url);
            }
        }
        $this->render('register', ['form' => $form]);
    }

    public function actionRecover()
    {
        $request = Yii::app()->getRequest();
        $form = new Recovery();
        $form->attributes = $request->getParam(get_class($form));
        if ($request->getIsPostRequest() && $form->validate()) {
            $user = User::model()->byEmail($form->EmailOrPhone)->byPrimaryPhone($form->EmailOrPhone, false)->byVisible(true)->find();
            if ($user !== null) {
                $form->ShowCode = true;
                if (empty($form->Code)) {
                    if (strstr($form->EmailOrPhone, '@') !== false) {
                        $mail = new MailRecover(new SESMailer(), $user);
                        $mail->send();
                        Yii::app()->user->setFlash('success', Yii::t('app', 'На указанный адрес электронной почты было отправлено письмо с кодом, введите его для смены пароля.'));
                    } else {
                        $sms = new SmsRecover(new SmsRu(), $user);
                        $sms->send();
                        Yii::app()->user->setFlash('success', Yii::t('app', 'На указанный номер телефона было отправлено сообщение с кодом, введите его для смены пароля.'));
                    }
                } else {
                    if ($user->checkRecoveryHash($form->Code)) {
                        $identity = new RunetId($user->RunetId);
                        $identity->authenticate();
                        Yii::app()->getUser()->login($identity);
                        $params = [];
                        $params['hash'] = $form->Code;
                        \Iframe::isFrame() ? $params['frame'] = 'true' : '';
                        $this->redirect(
                            $this->createUrl('/oauth/main/setpassword', $params)
                        );
                    } else {
                        $form->addError('Code', Yii::t('app', 'Указан не верный код для смены пароля.'));
                    }
                }
            } else {
                $form->addError('EmailOrPhone', Yii::t('app', 'Ошибка! Пользователь не найден.'));
            }
        }
        $this->render('recover', ['form' => $form]);
    }

    public function actionError()
    {
        $error = Yii::app()->errorHandler->error;
        $this->render('error');
    }

}

?>