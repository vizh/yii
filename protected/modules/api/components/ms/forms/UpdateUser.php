<?php
namespace api\components\ms\forms;

use api\models\Account;
use event\models\UserData;
use user\models\User;
use api\components\ms\callback\UpdateUser as UpdateUserCallback;

class UpdateUser extends BaseUser
{
    /** @var User  */
    protected $model;

    /**
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        foreach ($rules as $k => $rule) {
            if ($rule[0] === 'Email' || ($rule[0] === 'Phone' && $rule[1] === 'unique')) {
                unset($rules[$k]);
            }
        }
        $rules[] = ['Company,Position,Phone', 'required'];
        return $rules;
    }

    /**
     * @param User $user
     * @param Account $account
     * @param string $externalUserPartner
     */
    public function __construct(User $user, Account $account, $externalUserPartner = 'partner')
    {
        $this->model = $user;
        parent::__construct($account, $externalUserPartner);
    }

    /**
     * @return null|User
     * @throws \Exception
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $this->model->FirstName  =  $this->FirstName;
            $this->model->LastName   = $this->LastName;
            $this->model->FatherName = $this->FatherName;
            if ($this->model->PrimaryPhone != $this->Phone) {
                $this->model->PrimaryPhone = $this->Phone;
                $this->model->PrimaryPhoneVerify = false;
            }
            $this->model->save();

            $employment = $this->model->getEmploymentPrimary();
            if ($employment !== null) {
                if ($employment->Company !== $this->Company) {
                    $employment->chageCompany($this->Company);
                }
                $employment->Position = $this->Position;
                $employment->save();
            } else {
                $this->model->setEmployment($this->Company, $this->Position);
            }

            /** @var UserData $data */
            $data = UserData::getDefinedAttributeValues($this->account->Event, $this->model);
            foreach (['Country', 'City', 'Birthday'] as $name) {
                if (!isset($data[$name]) || $data[$name] !== $this->$name) {
                    $this->saveUserData();
                    break;
                }
            }
            $callback = new UpdateUserCallback($this->account);
            $callback->registerOnEvent($this->model);

            $transaction->commit();
            return $this->model;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        return false;
    }



}