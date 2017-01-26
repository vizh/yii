<?php
namespace event\models;

use application\components\ActiveRecord;
use application\components\utility\Texts;
use user\models\User;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $RoleId
 * @property int $UserId
 * @property string $Code
 * @property string $CreationTime
 * @property string $ActivationTime
 *
 * @property User $User
 *
 * Описание вспомогательных методов
 * @method Invite   with($condition = '')
 * @method Invite   find($condition = '', $params = [])
 * @method Invite   findByPk($pk, $condition = '', $params = [])
 * @method Invite   findByAttributes($attributes, $condition = '', $params = [])
 * @method Invite[] findAll($condition = '', $params = [])
 * @method Invite[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Invite byId(int $id, bool $useAnd = true)
 * @method Invite byEventId(int $id, bool $useAnd = true)
 * @method Invite byRoleId(int $id, bool $useAnd = true)
 * @method Invite byUserId(int $id, bool $useAnd = true)
 * @method Invite byCode(string $code, bool $useAnd = true)
 */
class Invite extends ActiveRecord
{
    /**
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventInvite';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
            'Role' => [self::BELONGS_TO, '\event\models\Role', 'RoleId'],
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId']
        ];
    }

    /**
     * @param User $user
     * @throws \Exception
     */
    public function activate(User $user)
    {
        if ($this->UserId !== null) {
            throw new \Exception(\Yii::t('app', 'Приглашение уже активировано'));
        }

        $this->UserId = $user->Id;
        $this->ActivationTime = date('Y-m-d H:i:s');
        $this->save();

        if (empty($this->Event->Parts)) {
            $this->Event->registerUser($this->User, $this->Role);
        } else {
            $this->Event->registerUserOnAllParts($this->User, $this->Role);
        }
    }

    /**
     * @param Event $event
     * @param Role $role
     * @return Invite
     */
    public static function create(Event $event, Role $role)
    {
        $invite = new Invite();
        $invite->RoleId = $role->Id;
        $invite->EventId = $event->Id;
        $utility = new Texts();
        $invite->Code = $utility->getUniqString($event->Id);
        $invite->save();

        return $invite;
    }
}