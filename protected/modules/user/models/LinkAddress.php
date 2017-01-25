<?php
namespace user\models;

use application\components\ActiveRecord;
use contact\models\Address;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $AddressId
 *
 * @property User $User
 * @property Address $Address
 *
 * Описание вспомогательных методов
 * @method LinkAddress   with($condition = '')
 * @method LinkAddress   find($condition = '', $params = [])
 * @method LinkAddress   findByPk($pk, $condition = '', $params = [])
 * @method LinkAddress   findByAttributes($attributes, $condition = '', $params = [])
 * @method LinkAddress[] findAll($condition = '', $params = [])
 * @method LinkAddress[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LinkAddress byId(int $id, bool $useAnd = true)
 * @method LinkAddress byUserId(int $id, bool $useAnd = true)
 * @method LinkAddress byAddressId(int $id, bool $useAnd = true)
 */
class LinkAddress extends ActiveRecord
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
        return 'UserLinkAddress';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
            'Address' => [self::BELONGS_TO, '\contact\models\Address', 'AddressId'],
        ];
    }
}
