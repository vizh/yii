<?php
namespace pay\models;

use application\components\ActiveRecord;
use user\models\User;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $ProductId
 * @property string $CreationTime
 *
 * @property Product $Product
 * @property User $User
 *
 * Описание вспомогательных методов
 * @method ProductUserAccess   with($condition = '')
 * @method ProductUserAccess   find($condition = '', $params = [])
 * @method ProductUserAccess   findByPk($pk, $condition = '', $params = [])
 * @method ProductUserAccess   findByAttributes($attributes, $condition = '', $params = [])
 * @method ProductUserAccess[] findAll($condition = '', $params = [])
 * @method ProductUserAccess[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method ProductUserAccess byId(int $id, bool $useAnd = true)
 * @method ProductUserAccess byUserId(int $id, bool $useAnd = true)
 * @method ProductUserAccess byProductId(int $id, bool $useAnd = true)
 */
class ProductUserAccess extends ActiveRecord
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
        return 'PayProductUserAccess';
    }

    public function relations()
    {
        return [
            'Product' => [self::BELONGS_TO, '\pay\models\Product', 'ProductId'],
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
        ];
    }
}