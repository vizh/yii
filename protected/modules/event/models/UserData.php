<?php
namespace event\models;

use application\components\ActiveRecord;
use event\components\UserDataManager;
use user\models\User;

/**
 * Class UserData
 *
 * @property int $Id
 * @property int $EventId
 * @property int $UserId
 * @property int $CreatorId
 * @property string $Attributes
 * @property string $CreationTime
 * @property bool $Deleted
 *
 * @property Event $Event
 * @property User $User
 * @property User $Creator
 *
 * @method UserData find($condition='',$params=array())
 * @method UserData findByPk($pk,$condition='',$params=array())
 * @method UserData[] findAll($condition='',$params=array())
 */

class UserData extends ActiveRecord
{
    protected $manager;

    public static function model($className = null)
    {
        $model = parent::model($className);
        $model->orderBy(['"t"."CreationTime"']);

        return $model;
    }

    /**
     * Creates an empty user data record
     * @param Event|int $event Event's model or event's identifier
     * @param User|int $user User's model or user's identifier
     * @return self
     */
    public static function createEmpty($event, $user)
    {
        if ($event instanceof Event) {
            $event = $event->Id;
        }

        if ($user instanceof User) {
            $user = $user->Id;
        }

        $model = new UserData();
        $model->EventId = $event;
        $model->UserId = $user;
        $definitions = $model->getManager()->getDefinitions();

        if (empty($definitions) || self::model()->byEventId($event)->byUserId($user)->exists()) {
            return $model;
        }

        $model->save();

        return $model;
    }

    /**
     * Fetches the user extended data. If it can't find the one it creates an empty record an returns it
     *
     * @param Event|int $event Event's model or event's identifier
     * @param User|int $user User's model or user's identifier
     * @return UserData
     */
    public static function fetch($event, $user)
    {
        if ($event instanceof Event) {
            $event = $event->Id;
        }

        if ($user instanceof User) {
            $user = $user->Id;
        }

        $data = UserData::model()->find([
            'condition' => '"EventId" = :eventId AND "UserId" = :userId',
            'params' => [
                ':eventId' => $event,
                ':userId' => $user
            ]
        ]);

        if (!$data) {
            $data = self::createEmpty($event, $user);
        }

        return $data;
    }

    /**
     * @param Event $event
     * @param User $user
     * @return string[]
     */
    public static function getDefinedAttributes($event, $user)
    {
        $userDataModels = UserData::model()
            ->byEventId($event->Id)
            ->byUserId($user->Id)
            ->findAll(['order' => 't."CreationTime" DESC']);

        $attributeNames = [];
        foreach ($userDataModels as $userData) {
            $manager = $userData->getManager();
            foreach ($manager->getDefinitions() as $definition) {
                $name = $definition->name;
                if (!empty($manager->{$name})) {
                    $attributeNames[] = $name;
                }
            }
        }

        $attributeNames = array_unique($attributeNames);

        return $attributeNames;
    }


    /**
     * @param Event $event
     * @param User $user
     * @return array
     */
    public static function getDefinedAttributeValues(Event $event, User $user)
    {
        $values = [];

        $userDataModels = $event->getUserData($user);
        if (!empty($userDataModels)) {
            foreach ($userDataModels as $userData) {
                $manager = $userData->getManager();
                foreach ($manager->getDefinitions() as $definition) {
                    $name = $definition->name;
                    if (!isset($values[$name]) && !empty($manager->$name)) {
                        $values[$name] = $manager->$name;
                    }
                }
            }
        }

        return $values;
    }

    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'EventUserData';
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, 'event\models\Event', 'EventId'],
            'User' => [self::BELONGS_TO, 'user\models\User', 'UserId'],
            'Creator' => [self::BELONGS_TO, 'user\models\User', 'CreatorId'],
        ];
    }

    /**
     * @return UserDataManager
     */
    public function getManager()
    {
        if (!$this->manager) {
            $this->manager = new UserDataManager($this);
        }

        return $this->manager;
    }

    /**
     * @param int $eventId
     * @param bool $useAnd
     * @return UserData
     */
    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."EventId" = :EventId';
        $criteria->params = ['EventId' => $eventId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param int $userId
     * @param bool $useAnd
     * @return UserData
     */
    public function byUserId($userId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."UserId" = :UserId';
        $criteria->params = ['UserId' => $userId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param bool $deleted
     * @param bool $useAnd
     * @return $this
     */
    public function byDeleted($deleted, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = (!$deleted ? 'NOT ' : '') . '"t"."Deleted"';
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * toDo: Требуется обновление до PostgreSQL 9.4 и проверки json_type
     * Выборка записей, содержащих указанный атрибут
     *
     * @param string $attribute
     * @param bool $useAnd
     * @return $this
     */
    public function byAttributeExists($attribute, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = "(\"Attributes\"->>'$attribute') NOTNULL";
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * toDo: Требуется обновление до PostgreSQL 9.4 и проверки json_type
     * Выборка записей, содержащих указанный атрибут c указанным значением
     *
     * @param string $attribute
     * @param string $value
     * @param bool $useAnd
     * @return $this
     */
    public function byAttribute($attribute, $value, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = "(\"Attributes\"->>'$attribute') = '$value'";
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }
}
