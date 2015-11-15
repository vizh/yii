<?php
namespace api\models\forms\user;

use api\components\Exception;
use api\models\Account;
use api\models\ExternalUser;
use oauth\models\Permission;
use user\models\forms\Register as BaseRegisterForm;

class Register extends BaseRegisterForm
{
    public $Password;
    public $ExternalId;

    /**
     * @var Account
     */
    protected $account;

    /** @var string */
    private $externalUserPartner = null;

    /**
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['Password', 'length', 'min' => 6, 'allowEmpty' => true],
            ['ExternalId', 'unique', 'className' => '\api\models\ExternalUser', 'attributeName' => 'ExternalId', 'criteria' => [
                'condition' => '"t"."AccountId" = :AccountId',
                'params' => [
                    'AccountId' => $this->account->Id
                ]
            ]]
        ]);
    }

    /**
     * @param Account $account
     * @param string $externalUserPartner
     */
    public function __construct(Account $account, $externalUserPartner = 'partner')
    {
        $this->account = $account;
        $this->externalUserPartner = $externalUserPartner;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'Password' =>  \Yii::t('app', 'Пароль'),
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

        $this->createExternalUser();

        $permission = new Permission();
        $permission->UserId = $this->model->Id;
        $permission->AccountId = $this->account->Id;
        $permission->Verified = true;
        $permission->save();
    }

    /**
     * @return ExternalUser|null
     */
    protected function createExternalUser()
    {
        if (!empty($this->ExternalId)) {
            $user = new ExternalUser();
            $user->UserId = $this->model->Id;
            $user->AccountId = $this->account->Id;
            $user->ExternalId = $this->ExternalId;
            $user->Partner = $this->externalUserPartner;
            $user->save();
            return $user;
        }
        return null;
    }

}