<?php
namespace event\models;

use application\components\ActiveRecord;
use catalog\models\Company;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $CompanyId
 * @property int $TypeId
 * @property int $Order
 *
 * @property Company $Company
 * @property PartnerType $Type
 *
 * Описание вспомогательных методов
 * @method Partner   with($condition = '')
 * @method Partner   find($condition = '', $params = [])
 * @method Partner   findByPk($pk, $condition = '', $params = [])
 * @method Partner   findByAttributes($attributes, $condition = '', $params = [])
 * @method Partner[] findAll($condition = '', $params = [])
 * @method Partner[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Partner byId(int $id, bool $useAnd = true)
 * @method Partner byEventId(int $id, bool $useAnd = true)
 * @method Partner byCompanyId(int $id, bool $useAnd = true)
 * @method Partner byTypeId(int $id, bool $useAnd = true)
 */
class Partner extends ActiveRecord
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
        return 'EventPartner';
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
            'Company' => [self::BELONGS_TO, '\catalog\models\company\Company', 'CompanyId'],
            'Type' => [self::BELONGS_TO, '\event\models\PartnerType', 'TypeId']
        ];
    }
}