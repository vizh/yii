<?php
namespace api\models;

use application\components\ActiveRecord;

/**
 * @property int $AccountId
 * @property int $UserId
 *
 * Описание вспомогательных методов
 * @method AccoutQuotaByUserLog   with($condition = '')
 * @method AccoutQuotaByUserLog   find($condition = '', $params = [])
 * @method AccoutQuotaByUserLog   findByPk($pk, $condition = '', $params = [])
 * @method AccoutQuotaByUserLog   findByAttributes($attributes, $condition = '', $params = [])
 * @method AccoutQuotaByUserLog[] findAll($condition = '', $params = [])
 * @method AccoutQuotaByUserLog[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method AccoutQuotaByUserLog byAccountId(int $id, bool $useAnd = true)
 * @method AccoutQuotaByUserLog byUserId(int $id, bool $useAnd = true)
 */
class AccoutQuotaByUserLog extends ActiveRecord
{
    /**
     * @param string $className
     *
     * @return Account
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    /**
     * @inheritDoc
     */
    public function tableName()
    {
        return 'ApiAccountQuotaByUserLog';
    }
}