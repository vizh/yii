<?php
namespace company\models;

use application\components\ActiveRecord;
use contact\models\Address;

/**
 * @property int $Id
 * @property int $CompanyId
 * @property int $SiteId
 *
 * @property Company $Company
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
 * @method LinkAddress byCompanyId(int $id, bool $useAnd = true)
 * @method LinkAddress bySiteId(int $id, bool $useAnd = true)
 */
class LinkAddress extends ActiveRecord
{
    /**
     * @param string $className
     * @return LinkAddress
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'CompanyLinkAddress';
    }

    public function relations()
    {
        return [
            'Company' => [self::BELONGS_TO, '\company\models\Company', 'CompanyId'],
            'Address' => [self::BELONGS_TO, '\contact\models\Address', 'AddressId'],
        ];
    }
}