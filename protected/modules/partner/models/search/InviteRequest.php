<?php
namespace partner\models\search\user;

use application\components\form\SearchFormModel;
use user\models\User;

class InviteRequest extends SearchFormModel
{
    public $Sender;
    public $Owner;
    public $Approved;

    public function rules()
    {
        return [
            ['Sender,Owner,Approved', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'Sender' => \Yii::t('app', 'Отправитель'),
            'Owner' => \Yii::t('app', 'Получатель'),
            'Approved' => \Yii::t('app', 'Статус')
        ];
    }


    /**
     *
     * @return \CDbCriteria
     */
    public function getCriteria()
    {
        $criteria = new \CDbCriteria();
        $criteria->with  = ['Owner', 'Sender'];
        if (!empty($this->Sender)) {
            $users = User::model()->bySearch($this->Sender)->findAll();
            $criteria->addInCondition('"t"."SenderUserId"', \CHtml::listData($users, 'Id', 'Id'));
        }

        if (!empty($this->Owner)) {
            $users = User::model()->bySearch($this->Sender)->findAll();
            $criteria->addInCondition('"t"."OwnerUserId"', \CHtml::listData($users, 'Id', 'Id'));
        }

        if ($this->Approved != '') {
            $criteria->addCondition('"t"."Approved" = :Approved');
            $criteria->params[':Approved'] = $this->Approved;
        }
        return $criteria;
    }

    /**
     * @return \CDataProvider
     */
    public function getDataProvider()
    {

    }
}
