<?php
namespace pay\components;

use event\models\Event;
use pay\models\Account;
use Yii;

class Controller extends \application\components\controllers\PublicMainController
{
    public $layout = '/layouts/pay';

    /** @var Event */
    protected $event;

    /**
     * @return \user\models\User
     */
    public function getUser()
    {
        if (Yii::app()->getUser()->getCurrentUser() !== null) {
            return Yii::app()->getUser()->getCurrentUser();
        }

        if (Yii::app()->tempUser->getCurrentUser() !== null) {
            return Yii::app()->tempUser->getCurrentUser();
        }

        return null;
    }

    /**
     * @return Event
     * @throws \CHttpException
     */
    public function getEvent()
    {
        if ($this->event === null) {
            $this->event = Event::model()
                ->byIdName(Yii::app()->getRequest()->getParam('eventIdName'))
                ->find();
            if ($this->event === null) {
                throw new \CHttpException(404);
            }
        }

        return $this->event;
    }

    public function createUrl($route, $params = [], $ampersand = '&')
    {
        $params['eventIdName'] = $this->getEvent()->IdName;

        return parent::createUrl($route, $params, $ampersand);
    }

    protected function beforeAction($action)
    {
        $isFastAuth = $this->getId() === 'cabinet' && $this->getAction()->getId() === 'auth';
        if ($this->getUser() === null && !$isFastAuth) {
            $error = $this->createTemporaryUser();
            $this->render('pay.views.system.unregister', ['error' => $error, 'account' => $this->getAccount()]);

            return false;
        }

        return parent::beforeAction($action);
    }

    protected function createTemporaryUser()
    {
        $email = Yii::app()->getRequest()->getParam('email');
        if ($email !== null) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
                Yii::app()->params['TemporaryUserRedirect'] = Yii::app()->createAbsoluteUrl('/pay/cabinet/index', ['eventIdName' => $this->getEvent()->IdName]);
                $user = new \user\models\User();
                $user->LastName = '';
                $user->FirstName = '';
                $user->Email = $email;
                $user->Visible = false;
                $user->Temporary = true;
                $user->register(!$this->getAccount()->SandBoxUser);
                if ($this->getAccount()->SandBoxUser) {
                    $this->sendSandboxMail($user);
                }

                $identity = new \application\components\auth\identity\RunetId($user->RunetId);
                $identity->authenticate();
                if ($identity->errorCode == \application\components\auth\identity\Base::ERROR_NONE) {
                    Yii::app()->tempUser->login($identity);
                    $this->refresh();
                } else {
                    throw new \CHttpException(404);
                }
            } else {
                return Yii::t('app', 'Введен не корректный Email');
            }
        }

        return false;
    }

    protected function sendSandboxMail(\user\models\User $user)
    {
        $mailer = new \mail\components\mailers\PhpMailer();
        $mail = new \pay\components\handlers\sandbox\Base($mailer, $user, $this->getEvent());
        $mail->send();
    }

    protected $account;

    /**
     * @return Account
     * @throws Exception
     */
    public function getAccount()
    {
        if ($this->account === null) {
            $this->account = Account::model()
                ->byEventId($this->getEvent()->Id)
                ->find();
            /** @noinspection NotOptimalIfConditionsInspection */
            if ($this->account === null) {
                throw new CodeException(CodeException::NO_PAY_ACCOUNT, [$this->getEvent()->Id, $this->getEvent()->IdName, $this->getEvent()->Title]);
            }
        }

        return $this->account;
    }
}
