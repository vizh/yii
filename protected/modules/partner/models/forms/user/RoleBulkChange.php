<?php
namespace partner\models\forms\user;

use application\components\form\FormModel;
use event\models\Participant;
use user\models\User;

/**
 * Class RoleBulkChange
 * @package partner\models\forms\user
 */
class RoleBulkChange extends FormModel
{
    public $Ids;
    public $RoleId;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'RoleId' => 'Статус'
        ];
    }

    public function rules()
    {
        return [
            ['Ids, RoleId', 'required'],
        ];
    }

    public function save()
    {
        $userIds = array_map(function($user){ return $user->Id; }, User::model()->findAllByPk($this->Ids));
        return Participant::model()->updateAll(['RoleId' => $this->RoleId], '"UserId" in ('.implode(',', $userIds).')') > 0;
    }
}