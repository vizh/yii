<?php
namespace pay\models;
use application\components\ActiveRecord;
use user\models\User;

/**
 * Class ProductCheck
 * @package pay\models
 * @property int $Id
 * @property int $UserId
 * @property int $ProductId
 * @property int $OperatorId
 * @property string $CreationTime
 * @property string $CheckTime
 *
 * @property User $User
 *
 * @method ProductCheck byProductId(int $productId)
 */
class ProductCheck extends ActiveRecord
{
    /**
     * @param string $className
     * @return ProductCheck
     */
    public static function model($className=__CLASS__)
    {
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