<?php
namespace company\models;

use application\components\ActiveRecord;
use contact\models\Phone;

/**
 * @property int $Id
 * @property int $CompanyId
 * @property int $PhoneId
 *
 * @property Company $Company
 * @property Phone $Phone
 *
 * Описание вспомогательных методов
 * @method LinkPhone   with($condition = '')
 * @method LinkPhone   find($condition = '', $params = [])
 * @method LinkPhone   findByPk($pk, $condition = '', $params = [])
 * @method LinkPhone   findByAttributes($attributes, $condition = '', $params = [])
 * @method LinkPhone[] findAll($condition = '', $params = [])
 * @method LinkPhone[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LinkPhone byId(int $id, bool $useAnd = true)
 * @method LinkPhone byCompanyId(int $id, bool $useAnd = true)
 * @method LinkPhone byPhoneId(int $id, bool $useAnd = true)
 */
class LinkPhone extends ActiveRecord
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
        return 'CompanyLinkPhone';
    }

    public function relations()
    {
        return [
            'Company' => [self::BELONGS_TO, '\company\models\Company', 'CompanyId'],
            'Phone' => [self::BELONGS_TO, '\contact\models\Phone', 'PhoneId'],
        ];
    }
}
