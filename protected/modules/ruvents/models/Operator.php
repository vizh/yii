<?php
namespace ruvents\models;

use application\components\ActiveRecord;
use JsonSerializable;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Login
 * @property string $Password
 * @property string $Role
 * @property string $LastLoginTime
 *
 * Описание вспомогательных методов
 * @method Operator   with($condition = '')
 * @method Operator   find($condition = '', $params = [])
 * @method Operator   findByPk($pk, $condition = '', $params = [])
 * @method Operator   findByAttributes($attributes, $condition = '', $params = [])
 * @method Operator[] findAll($condition = '', $params = [])
 * @method Operator[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Operator byId(int $id, bool $useAnd = true)
 * @method Operator byEventId(int $id, bool $useAnd = true)
 * @method Operator byLogin(string $login, bool $useAnd = true)
 * @method Operator byRole(string $role, bool $useAnd = true)
 */
class Operator extends ActiveRecord implements JsonSerializable
{
    const RoleOperator = 'Operator';
    const RoleAdmin = 'Admin';

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
        return 'RuventsOperator';
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