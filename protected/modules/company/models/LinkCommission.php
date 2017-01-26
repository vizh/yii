<?php
namespace company\models;

use application\components\ActiveRecord;

/**
 * @property int $CompanyId
 * @property int $CommissionId
 *
 * Описание вспомогательных методов
 * @method LinkCommission   with($condition = '')
 * @method LinkCommission   find($condition = '', $params = [])
 * @method LinkCommission   findByPk($pk, $condition = '', $params = [])
 * @method LinkCommission   findByAttributes($attributes, $condition = '', $params = [])
 * @method LinkCommission[] findAll($condition = '', $params = [])
 * @method LinkCommission[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LinkCommission byCompanyId(int $id, bool $useAnd = true)
 * @method LinkCommission byCommissionId(int $id, bool $useAnd = true)
 */
class LinkCommission extends ActiveRecord
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

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'CompanyLinkCommission';
    }
}