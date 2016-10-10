<?php
namespace ruvents\models;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Login
 * @property string $Password
 * @property string $Role
 * @property string $LastLoginTime
 *
 * @method \ruvents\models\Operator find()
 * @method \ruvents\models\Operator findByAttributes()
 */
class Operator extends \CActiveRecord implements \JsonSerializable
{
    const RoleOperator = 'Operator';
    const RoleAdmin = 'Admin';

    /**
     * @static
     * @param string $className
     * @return Operator
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'RuventsOperator';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    /**
     * @param int $eventId
     * @param bool $useAnd
     * @return $this
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
     * Specify data which should be serialized to JSON
     *
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'Id' => $this->Id,
            'Login' => $this->Login,
            'Password' => $this->Password
        ];
    }
}