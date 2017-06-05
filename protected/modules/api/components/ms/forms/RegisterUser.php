<?php
namespace api\components\ms\forms;

use api\components\ms\mail\Register as RegisterMail;
use api\models\Account;
use mail\components\mailers\SESMailer;
use user\models\User;

class RegisterUser extends BaseUser
{
    /**
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        parent::__construct($account, Account::ROLE_MICROSOFT);

        $request = \Yii::app()->getRequest();

        $user = User::model()->byEmail($request->getParam('Email'))->byVisible(true)->find();
        if ($user !== null && mb_strtolower($request->getParam('LastName')) === mb_strtolower($user->LastName) && mb_strtolower($request->getParam('FirstName')) === mb_strtolower($user->FirstName)) {
            $this->setActiveRecord($user);
        }
    }

    /**
     * @inheritdoc
     */
    public function fillFromPost()
    {
        parent::fillFromPost();
        if (!$this->isUpdateMode()) {
            $this->Password = \Utils::GeneratePassword();
        }
    }

    /**
     * @return array
     */
    public function rules()
    {
        $rules = [
            ['Phone', 'filter', 'filter' => '\application\components\utility\Texts::getOnlyNumbers'],
            ['FirstName,LastName,FatherName,Email,Company,Position,Country,City,Birthday', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            ['FirstName,LastName,FatherName,Email,Company,Position,Country,City,Phone,Password,Birthday', 'safe'],
            [
                'ExternalId',
                'unique',
                'className' => '\api\models\ExternalUser',
                'attributeName' => 'ExternalId',
                'criteria' => [
                    'condition' => '"t"."AccountId" = :AccountId',
                    'params' => [
                        'AccountId' => $this->account->Id
                    ]
                ]
            ]
        ];
        return $rules;
    }

    /**
     * @inheritDoc
     */
    protected function internalUpdateActiveRecord()
    {
        $this->saveUserData();
        $mail = new RegisterMail(new SESMailer(), $this->model);
        $mail->send();
    }

    /**
     *
     */
    protected function internalCreateActiveRecord()
    {
        parent::internalCreateActiveRecord();
        $this->saveUserData();

        $mail = new RegisterMail(new SESMailer(), $this->model, $this->Password);
        $mail->send();
    }

    /**
     * @return bool
     */
    protected function isHiddenUser()
    {
        return true;
    }
}