<?php
namespace commission\models\forms;

class User extends \CFormModel
{
    const DATE_FORMAT = 'dd.MM.yyyy';

    public $Id;
    public $RunetId;
    public $RoleId;
    public $JoinDate;
    public $ExitDate;

    public function rules()
    {
        return [
            ['RunetId, RoleId, JoinDate', 'required'],
            ['Id', 'exist', 'allowEmpty' => true, 'className' => '\commission\models\User', 'attributeName' => 'Id'],
            ['RunetId', 'exist', 'className' => '\user\models\User', 'attributeName' => 'RunetId'],
            ['RoleId', 'exist', 'className' => '\commission\models\Role', 'attributeName' => 'Id'],
            ['JoinDate', 'date', 'format' => self::DATE_FORMAT],
            ['ExitDate', 'date', 'allowEmpty' => true, 'format' => self::DATE_FORMAT],
        ];
    }

    public function attributeLabels()
    {
        return [
            'RunetId' => \Yii::t('app', 'RUNET&mdash;ID'),
            'RoleId' => \Yii::t('app', 'Роль'),
            'JoinDate' => \Yii::t('app', 'Дата присоединения'),
            'ExitDate' => \Yii::t('app', 'Дата выхода')
        ];
    }

    public function getRoleList()
    {
        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."Priority" DESC';
        return \CHtml::listData(\commission\models\Role::model()->findAll($criteria), 'Id', 'Title');
    }
}
