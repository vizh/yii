<?php
namespace partner\models\forms\user;

use application\components\form\FormModel;
use event\models\Event;
use event\models\Role;
use user\models\User;

/**
 * Class RoleBulkChange
 * @package partner\models\forms\user
 */
class RoleBulkChange extends FormModel
{
    /** @var Event */
    public $Event;
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
            ['Ids', 'required'],
            ['RoleId', 'numerical', 'allowEmpty' => true]
        ];
    }

    public function save()
    {
        $role = Role::findOne($this->RoleId);
        $users = User::model()->findAllByPk($this->Ids);
        foreach ($users as $user) {
            if ($role) {
                $this->Event->registerUser($user, $role);
            } elseif ($this->RoleId == -1) {
                $this->Event->unregisterUser($user);
            }
        }
        return true;
    }
}