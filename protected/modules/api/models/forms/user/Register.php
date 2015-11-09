<?php
namespace api\models\forms\user;

use api\components\Exception;
use api\models\Account;
use oauth\models\Permission;
use user\models\forms\Register as BaseRegisterForm;

class Register extends BaseRegisterForm
{
    public $Password;

    /**
     * @var Account
     */
    private $account;

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
     */
    public function __construct(Account $account)
    {
        $this->account = $account;
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
            'Position' => $request->getParam('Position')
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
        $permission = new Permission();
        $permission->UserId = $this->model->Id;
        $permission->AccountId = $this->account->Id;
        $permission->Verified = true;
        $permission->save();
    }

}