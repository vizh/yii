<?php

namespace raec\models\forms;

use CHtml;
use raec\models\Role;
use Yii;

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
            ['RunetId,RoleId,JoinDate', 'required'],
            ['Id', 'exist', 'allowEmpty' => true, 'className' => '\raec\models\User', 'attributeName' => 'Id'],
            ['RunetId', 'exist', 'className' => '\user\models\User', 'attributeName' => 'RunetId'],
            ['RoleId', 'exist', 'className' => '\raec\models\Role', 'attributeName' => 'Id'],
            ['JoinDate', 'date', 'format' => self::DATE_FORMAT],
            ['ExitDate', 'date', 'allowEmpty' => true, 'format' => self::DATE_FORMAT],
        ];
    }

    public function attributeLabels()
    {
        return [
            'RunetId' => Yii::t('app', 'RUNET&mdash;ID'),
            'RoleId' => Yii::t('app', 'Роль'),
            'JoinDate' => Yii::t('app', 'Дата присоединения'),
            'ExitDate' => Yii::t('app', 'Дата выхода')
        ];
    }

    public function getRoleList()
    {
        $roles = Role::model()
            ->orderBy(['t."Priority"' => SORT_DESC])
            ->findAll();

        return CHtml::listData($roles, 'Id', 'Title');
    }
}
