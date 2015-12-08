<?php
namespace api\components\ms\forms;

use api\models\Account;
use mail\components\mailers\MandrillMailer;
use user\models\User;
use api\components\ms\mail\Register as RegisterMail;

class RegisterUser extends BaseUser
{
    /**
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        parent::__construct($account, 'microsoft');

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
            ['FirstName,LastName,FatherName,Email,Company,Position,Country,City', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            ['FirstName,LastName,FatherName,Email,Company,Position,Country,City,Phone,ExternalId,Password', 'safe'],
        ];
        return $rules;
    }

    /**
     * @inheritDoc
     */
    protected function internalUpdateActiveRecord()
    {
        $this->saveUserData();
        if (!empty($this->Company)) {
            $this->model->setEmployment($this->Company, $this->Position);
        }

        if (!empty($this->Phone)) {
            if (!$this->model->PrimaryPhoneVerify) {
                $this->model->PrimaryPhone = $this->Phone;
                $this->model->save();
            } elseif ($this->model->PrimaryPhone !== $this->Phone) {
                $this->model->setContactPhone($this->Phone);
            }
        }
        $mail = new RegisterMail(new MandrillMailer(), $this->model);
        $mail->send();
    }


    /**
     *
     */
    protected function internalCreateActiveRecord()
    {
        parent::internalCreateActiveRecord();
        $this->saveUserData();

        $mail = new RegisterMail(new MandrillMailer(), $this->model, $this->Password);
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