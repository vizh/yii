<?php
namespace partner\models\forms\orderitem;

use application\components\form\CreateUpdateForm;
use application\helpers\Flash;
use pay\models\OrderItem;
use user\models\User;

class Redirect extends CreateUpdateForm
{
    /** @var OrderItem */
    protected $model;

    public $Owner;

    /**
     * @return array|void
     */
    public function rules()
    {
        return [
            ['Owner', 'required'],
            ['Owner', 'exist', 'className' => '\user\models\User', 'attributeName' => 'RunetId']
        ];
    }

    public function attributeLabels()
    {
        return [
            'Owner' => \Yii::t('app', 'Пользователь')
        ];
    }

    /**
     * @inheritdoc
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $owner = User::model()->byRunetId($this->Owner)->find();
        if ($this->model->changeOwner($owner)) {
            return $this->model;
        } else {
            Flash::setError(\Yii::t('app', 'Произошла ошибка при переносе заказа!'));
            return null;
        }
    }

} 