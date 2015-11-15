<?php
namespace api\models\forms\user;

use api\models\Account;
use event\models\UserData;
use user\models\User;

class MsRegister extends Register
{
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
        $user = User::model()->byEmail($this->Email)->byVisible(true)->find();
        if ($user !== null && mb_strtolower($this->LastName) === mb_strtolower($user->LastName) && mb_strtolower($this->FirstName) === mb_strtolower($user->FirstName)) {
            $this->model = $user;
        }
    }

    /**
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        foreach ($rules as $k => $rule) {
            if ($rule[0] === 'Phone') {
                unset($rules[$k]);
            }
        }
        $rules[] = ['Phone', 'safe'];
        return $rules;
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
        $country = \Yii::app()->getRequest()->getParam('Country');
        $city = \Yii::app()->getRequest()->getParam('City');

        $attributes = [];
        if (!empty($country)) {
            $attributes['Country'] = $country;
        }
        if (!empty($city)) {
            $attributes['City'] = $city;
        }

        if (!empty($attributes)) {
            $data = new UserData();
            $data->EventId = $this->account->EventId;
            $data->CreatorId = $data->UserId = $this->model->Id;
            $manager = $data->getManager();
            foreach ($attributes as $name => $value) {
                $manager->$name = $value;
            }
            $data->save();
        }
    }

}