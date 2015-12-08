<?php
namespace api\models\forms;

use api\models\Account;
use api\models\ExternalUser as ExternalUserModel;
use application\components\form\CreateUpdateForm;
use user\models\User;

class ExternalUser extends CreateUpdateForm
{
    public $ExternalId;

    /** @var Account */
    private $account;

    /** @var User */
    private $user = null;

    /** @var string */
    private $partner;

    /**
     * @inheritDoc
     */
    public function __construct(Account $account, $partner, User $user = null)
    {
        $this->account = $account;
        $this->partner = $partner;
        parent::__construct($user);
    }

    /**
     * @inheritDoc
     */
    public function setActiveRecord(\CActiveRecord $model)
    {
        $this->user = $model;
        $this->model = ExternalUserModel::model()->byAccountId($this->account->Id)->byUserId($model->Id)->byPartner($this->partner)->find();
        $this->loadData();
    }


    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            ['ExternalId', 'unique', 'className' => '\api\models\ExternalUser', 'attributeName' => 'ExternalId', 'criteria' => [
                'condition' => '"t"."AccountId" = :AccountId',
                'params' => [
                    'AccountId' => $this->account->Id
                ]
            ]]
        ];
    }

    /**
     * @inheritDoc
     */
    public function createActiveRecord()
    {
        if (empty($this->ExternalId)) {
            return null;
        }

        $this->model = new ExternalUserModel();
        $this->model->UserId    = $this->user->Id;
        $this->model->AccountId = $this->account->Id;
        $this->model->Partner   = $this->partner;
        return $this->updateActiveRecord();
    }

    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $this->model->ExternalId = $this->ExternalId;
        $this->model->save();
        return $this->model;
    }
}