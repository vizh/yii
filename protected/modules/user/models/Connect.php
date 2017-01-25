<?php
namespace user\models;

use application\components\ActiveRecord;

/**
 * @property int $UserConnectId
 * @property int $UserId
 * @property int $ServiceTypeId
 * @property string $Hash
 *
 * @property User $User
 *
 * Описание вспомогательных методов
 * @method Connect   with($condition = '')
 * @method Connect   find($condition = '', $params = [])
 * @method Connect   findByPk($pk, $condition = '', $params = [])
 * @method Connect   findByAttributes($attributes, $condition = '', $params = [])
 * @method Connect[] findAll($condition = '', $params = [])
 * @method Connect[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Connect byUserConnectId(int $id, bool $useAnd = true)
 * @method Connect byUserId(int $id, bool $useAnd = true)
 * @method Connect byServiceTypeId(int $id, bool $useAnd = true)
 * @method Connect byHash(string $hash, bool $useAnd = true)
 */
class Connect extends ActiveRecord
{
    const TwitterId = 13;
    const FacebookId = 14;

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
        return 'UserConnect';
    }

    public function primaryKey()
    {
        return 'UserConnectId';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, 'User', 'UserId'],
        ];
    }
}