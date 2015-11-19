<?php
namespace api\components\ms;

use api\models\Account;
use api\models\forms\user\Register;
use api\components\ms\mail\Register as RegisterMail;
use event\models\UserData;
use mail\components\mailers\MandrillMailer;
use user\models\User;

class FormRegister extends Register
{
    public $Country;
    public $City;

    /**
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        parent::__construct($account, 'microsoft');
    }

    /**
     * @inheritdoc
     */
    public function fillFromPost()
    {
        parent::fillFromPost();
        $request = \Yii::app()->getRequest();
        $this->Country = $request->getParam('Country');
        $this->City = $request->getParam('City');

        $user = User::model()->byEmail($this->Email)->byVisible(true)->find();
        if ($user !== null && mb_strtolower($this->LastName) === mb_strtolower($user->LastName) && mb_strtolower($this->FirstName) === mb_strtolower($user->FirstName)) {
            $this->model = $user;
        } else {
            $this->Password = \Utils::GeneratePassword();
        }
    }

    /**
     * @return array
     */
    public function rules()
    {
        $rules = [
            ['FirstName,LastName,FatherName,Email,Company,Position,Country,City,Phone', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            ['FirstName,LastName,FatherName,Email,Company,Position,Country,City,Phone,ExternalId,Password', 'safe'],
        ];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'Country' => 'Страна',
            'City' => 'Город'
        ]);
    }


    /**
     * @throws \application\components\Exception
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $this->createExternalUser();
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

            $transaction->commit();
            return $this->model;
        } catch (\Exception $e) {
            $transaction->rollBack();
        }
        return null;
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

    /**
     *
     */
    private function saveUserData()
    {
        $data = new UserData();
        $data->EventId = $this->account->EventId;
        $data->CreatorId = $data->UserId = $this->model->Id;
        $manager = $data->getManager();
        $manager->City = $this->City;
        $manager->Country = $this->Country;
        $data->save();
    }
}