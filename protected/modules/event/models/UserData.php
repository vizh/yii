<?php
namespace event\models;

use application\components\ActiveRecord;
use application\components\CDbCriteria;
use application\components\Exception;
use event\components\UserDataManager;
use user\models\User;
use Yii;

/**
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
 * Описание вспомогательных методов
 * @method UserData   with($condition = '')
 * @method UserData   find($condition = '', $params = [])
 * @method UserData   findByPk($pk, $condition = '', $params = [])
 * @method UserData   findByAttributes($attributes, $condition = '', $params = [])
 * @method UserData[] findAll($condition = '', $params = [])
 * @method UserData[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method UserData byId(int $id, bool $useAnd = true)
 * @method UserData byEventId(int $id, bool $useAnd = true)
 * @method UserData byUserId(int $id, bool $useAnd = true)
 * @method UserData byCreatorId(int $id, bool $useAnd = true)
 * @method UserData byDeleted(bool $deleted, bool $useAnd = true)
 */
class UserData extends ActiveRecord
{
    protected $manager;

    /**
     * @param null $className
     * @return UserData
     */
    public static function model($className = null)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    protected function beforeFind()
    {
        parent::beforeFind();

        $this->getDbCriteria()->mergeWith(
            CDbCriteria::create()
                ->setOrder('"t"."CreationTime" DESC')
        );
    }

    /**
     * Creates an empty user data record
     *
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
        $attributeNames = [];

        foreach ($event->getUserData($user) as $userData) {
            $manager = $userData->getManager();
            foreach ($manager->getDefinitions() as $definition) {
                $name = $definition->name;
                if (!empty($manager->{$name})) {
                    $attributeNames[] = $name;
                }
            }
        }

        return array_unique($attributeNames);
    }

    /**
     * @param Event $event
     * @param User $user
     * @return array
     */
    public static function getDefinedAttributeValues(Event $event, User $user)
    {
        $values = [];

        foreach ($event->getUserData($user) as $userData) {
            $manager = $userData->getManager();
            foreach ($manager->getDefinitions() as $definition) {
                $name = $definition->name;
                if (!isset($values[$name]) && !empty($manager->$name)) {
                    $values[$name] = $definition->getExportValue($manager);
                }
            }
        }

        return $values;
    }

    /**
     * @param Event $event
     * @param User $user
     * @param array $attributes
     * @throws \application\components\Exception
     */
    public static function set(Event $event, User $user, array $attributes)
    {
        foreach ($event->getUserData($user, true) as $userData) {
            $manager = $userData->getManager();
            foreach ($attributes as $name => $value) {
                $valueCurrent = $manager->$name;
                if ($valueCurrent === null || $valueCurrent !== $value) {
                    $manager->$name = $value;
                }
            }
            if ($manager->validate() === false) {
                foreach ($manager->getErrors() as $attributeName => $errorMessages) {
                    throw new Exception("Ошибка валидации атрибута {$attributeName}: ".implode(', ', $errorMessages));
                }
            }
            $userData->save();
        }
    }

    /**
     * Переключает режим возвращения RAW данных для переводимых атрибутов. Вместо значения
     * для текущей локали в рамках хита будут возвращаться данные для всех локалей сразу.
     */
    public static function setEnableRawValues()
    {
        $GLOBALS['YII_TRANSlATABLE_ATTRIBUTE_FORCE_RAW_VALUES'] = true;
    }

    /**
     * Отключает режим возвращения RAW данных для переводимых атрибутов.
     */
    public static function setDisableRawValues()
    {
        unset($GLOBALS['YII_TRANSlATABLE_ATTRIBUTE_FORCE_RAW_VALUES']);
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
        if ($this->manager === null) {
            $this->manager = new UserDataManager($this);
        }

        return $this->manager;
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
     * Выборка записей, содержащих указанный атрибут c указанным значением.
     *
     * @param string $attribute
     * @param string $value
     * @param bool $useAnd
     * @return $this
     */
    public function byAttribute($attribute, $value, $useAnd = true)
    {
        $language = Yii::app()->getLanguage();
        $criteria = new \CDbCriteria();
        $criteria->condition = "(\"Attributes\"->>'$attribute') = '$value' OR (\"Attributes\"->'$attribute'->'$language') = '$value'";
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }
}
