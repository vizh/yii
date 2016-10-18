<?php
namespace ruvents\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $OperatorId
 * @property int $EventId
 * @property int $PartId
 * @property int $UserId
 * @property int $RoleId
 * @property string $CreationTime
 *
 * @property \event\models\Role $Role
 * @property \user\models\User $User
 * @property \event\models\Part $Part
 *
 * @method Badge byUserId($id, $useAnd = true)
 *
 * Описание вспомогательных методов
 * @method Badge   with($condition = '')
 * @method Badge   find($condition = '', $params = [])
 * @method Badge   findByPk($pk, $condition = '', $params = [])
 * @method Badge   findByAttributes($attributes, $condition = '', $params = [])
 * @method Badge[] findAll($condition = '', $params = [])
 * @method Badge[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 */
class Badge extends ActiveRecord
{
    public $CountForCriteria = null;
    public $DateForCriteria = null;

    /**
     * @static
     * @param string $className
     * @return Badge
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'RuventsBadge';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [
            'Role' => [self::BELONGS_TO, '\event\models\Role', 'RoleId'],
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
            'Part' => [self::BELONGS_TO, '\event\models\Part', 'PartId'],
            'Operator' => [self::BELONGS_TO, '\ruvents\models\Operator', 'OperatorId']
        ];
    }

    /**
     * @param $eventId
     * @param bool $useAnd
     * @return Badge
     */
    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."EventId" = :EventId';
        $criteria->params = [':EventId' => $eventId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param int|null $partId
     * @param bool $useAnd
     *
     * @return Badge
     */
    public function byPartId($partId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        if ($partId !== null) {
            $criteria->condition = '"t"."PartId" = :PartId';
            $criteria->params = [':PartId' => $partId];
        } else {
            $criteria->condition = '"t"."PartId" IS NULL';
        }
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

}