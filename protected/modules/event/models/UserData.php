<?php
namespace event\models;

use event\components\UserDataManager;
use user\models\User;

/**
 * Class UserData
 * @package event\models
 *
 * @property int $Id
 * @property int $EventId
 * @property int $UserId
 * @property int $CreatorId
 * @property string $Attributes
 * @property string $CreationTime
 *
 * @property Event $Event
 * @property User $User
 * @property User $Creator
 *
 * @method UserData find($condition='',$params=array())
 * @method UserData findByPk($pk,$condition='',$params=array())
 * @method UserData[] findAll($condition='',$params=array())
 */

class UserData extends \CActiveRecord
{
    /**
     * @param string $className
     * @return UserData
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventUserData';
    }

    public function primaryKey()
    {
        return ['EventId', 'UserId'];
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
            'Creator' => [self::BELONGS_TO, '\user\models\User', 'CreatorId'],
        ];
    }

    protected $manager = null;

    /**
     * @return UserDataManager
     */
    public function getManager()
    {
        if ($this->manager === null) {
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
     * @param Event $event
     * @param User $user
     * @return string[]
     */
    public static function getDefinedAttributes($event, $user)
    {
        $userDataModels = UserData::model()->byEventId($event->Id)->byUserId($user->Id)
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
} 