<?php
namespace api\models\forms\user;

use api\components\Exception;
use api\models\Account;
use api\models\forms\ExternalUser;
use event\models\Event;
use event\models\Participant;
use oauth\models\Permission;
use user\models\forms\fields\Email;
use user\models\forms\Register as BaseRegisterForm;
use user\models\User;

/**
 * Class Register
 */
class Register extends BaseRegisterForm
{
    /**
     * @var string User password
     */
    public $Password;

    /**
     * @var Account
     */
    protected $account;

    /**
     * @var string
     */
    private $externalUserPartner;

    /**
     * @var int Identifier of the event for register
     */
    private $eventId;

    /**
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['Password', 'length', 'min' => 6, 'allowEmpty' => true]
        ]);
    }

    /**
     * @param Account $account
     * @param string $externalUserPartner
     * @param int $eventId Identifier of the event that will be used for validation of uniqueness of an email
     */
    public function __construct(Account $account, $externalUserPartner = 'partner', $eventId = null)
    {
        $this->account = $account;
        $this->externalUserPartner = $externalUserPartner;

        parent::__construct(null);
    }

    /**
     * @inheritDoc
     */
    protected function initForms()
    {
        parent::initForms();

        $this->registerForm(ExternalUser::className(), [$this->account, $this->externalUserPartner]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'Password' => \Yii::t('app', 'Пароль'),
            'ExternalId' => \Yii::t('app', 'Внешний Id')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function fillFromPost()
    {
        $request = \Yii::app()->getRequest();
        $attributes = [
            'Email' => $request->getParam('Email'),
            'LastName' => $request->getParam('LastName'),
            'FirstName' => $request->getParam('FirstName'),
            'FatherName' => $request->getParam('FatherName'),
            'Password' => $request->getParam('Password'),
            'Phone' => $request->getParam('Phone'),
            'Company' => $request->getParam('Company'),
            'Position' => $request->getParam('Position'),
            'ExternalId' => $request->getParam('ExternalId')
        ];

        $this->setAttributes($attributes);
    }

    /**
     * @inheritdoc
     */
    public function validate($attributes = null, $clearErrors = true)
    {
        $valid = parent::validate($attributes, $clearErrors);
        if (!$valid) {
            foreach ($this->getErrors() as $attribute => $messages) {
                foreach ($messages as $message) {
                    throw new Exception(204, [$message]);
                }
            }
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function validateEmail($attribute, $params) {
        if (!$this->isHiddenUser()) {
            return call_user_func_array($params['method'], [$attribute, $this->isEmailUnique()]);
        }

        if ($this->isEmailUnique()) {
            $emailForm = $params['method'][0];
            return call_user_func([$this, 'validateEmailUnique'], $emailForm);
        }

        return true;
    }

    /**
     * Validates uniqueness of an email by using a specified event identifier
     * @param Email $emailForm Email form for errors
     * @return bool
     */
    public function validateEmailUnique($emailForm)
    {
        $event = null;
        if ($eventId = $this->fetchEventId()) {
            $event = Event::model()->findByPk($eventId);
        }

        $email = $emailForm->Email;

        if ($event) {
            $exists = User::model()->byEmail($email)->exists([
                'join' => 'INNER JOIN "EventParticipant" p ON p."UserId" = t."Id" AND p."EventId" = :eventId',
                'params' => [':eventId' => $event->Id]
            ]);

            if ($exists && $participant = Participant::model()->byEventId($eventId)->byParticipantEmail($email)) {
                $participant->sendTicket();
            }

            $errorMessage = <<<MESSAGE
                Пользователь с таким Email уже зарегистрирован на мероприятие.
                Письмо с электронным билетом было отправлено повторно на адрес, указанный при регистрации.
MESSAGE;
        } else {
            $exists = User::model()->byEmail($email)->exists();
            $errorMessage = 'Пользователь с таким Email уже существует в RUNET-ID';
        }

        if ($exists) {
            $this->addError('Email', $errorMessage);
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function isHiddenUser()
    {
        $visible = (bool) \Yii::app()->getRequest()->getParam('Visible', true);
        return !$visible;
    }

    /**
     * @inheritdoc
     */
    protected function internalCreateActiveRecord()
    {
        parent::internalCreateActiveRecord();

        $permission = new Permission();
        $permission->UserId = $this->model->Id;
        $permission->AccountId = $this->account->Id;
        $permission->Verified = true;
        $permission->save();
    }

    /**
     * @inheritdoc
     */
    protected function isEmailUnique()
    {
        return (bool) \Yii::app()->getRequest()->getParam('UniqueEmail', false);
    }

    /**
     * Returns identifier of the event
     * @return int|null
     */
    private function fetchEventId()
    {
        return \Yii::app()->getRequest()->getParam('EventId');
    }
}
