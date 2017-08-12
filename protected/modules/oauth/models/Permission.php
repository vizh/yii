<?php
namespace oauth\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $AccountId
 * @property string $CreationTime
 * @property bool $Verified
 * @property bool $Deleted
 * @property string $DeletionTime
 *
 * Описание вспомогательных методов
 * @method Permission   with($condition = '')
 * @method Permission   find($condition = '', $params = [])
 * @method Permission   findByPk($pk, $condition = '', $params = [])
 * @method Permission   findByAttributes($attributes, $condition = '', $params = [])
 * @method Permission[] findAll($condition = '', $params = [])
 * @method Permission[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Permission byId(int $id, bool $useAnd = true)
 * @method Permission byUserId(int $id, bool $useAnd = true)
 * @method Permission byAccountId(int $id, bool $useAnd = true)
 * @method Permission byVerifed(bool $verifed = true, bool $useAnd = true)
 * @method Permission byDeleted(bool $deleted = true, bool $useAnd = true)
 */
class Permission extends ActiveRecord
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
        return 'OAuthPermission';
    }
}
