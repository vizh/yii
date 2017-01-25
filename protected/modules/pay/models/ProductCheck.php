<?php
namespace pay\models;

use application\components\ActiveRecord;
use user\models\User;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $ProductId
 * @property int $OperatorId
 * @property string $CreationTime
 * @property string $CheckTime
 *
 * @property User $User
 *
 * Описание вспомогательных методов
 * @method ProductCheck   with($condition = '')
 * @method ProductCheck   find($condition = '', $params = [])
 * @method ProductCheck   findByPk($pk, $condition = '', $params = [])
 * @method ProductCheck   findByAttributes($attributes, $condition = '', $params = [])
 * @method ProductCheck[] findAll($condition = '', $params = [])
 * @method ProductCheck[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method ProductCheck byId(int $id, bool $useAnd = true)
 * @method ProductCheck byUserId(int $id, bool $useAnd = true)
 * @method ProductCheck byProductId(int $id, bool $useAnd = true)
 * @method ProductCheck byOperatorId(int $id, bool $useAnd = true)
 */
class ProductCheck extends ActiveRecord
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
        return 'PayProductCheck';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
            'Product' => [self::BELONGS_TO, '\pay\models\Product', 'ProductId']
        ];
    }

    /**
     * @param int $eventId
     * @param bool $useAnd
     * @return $this
     */
    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->with = ['Product'];
        $criteria->condition = '"Product"."EventId" = :EventId';
        $criteria->params = ['EventId' => $eventId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }
}