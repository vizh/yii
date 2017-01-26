<?php
namespace event\models\section;

use application\components\ActiveRecord;
use catalog\models\Company;

/**
 * @property int $Id
 * @property int $SectionId
 * @property int $CompanyId
 * @property int $Order
 *
 * @property Company $Company
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
 * @method Partner bySectionId(int $id, bool $useAnd = true)
 * @method Partner byCompanyId(int $id, bool $useAnd = true)
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
        return 'EventSectionPartner';
    }

    public function relations()
    {
        return [
            'Section' => [self::BELONGS_TO, '\event\models\section\Section', 'SectionId'],
            'Company' => [self::BELONGS_TO, '\catalog\models\Company', 'CompanyId']
        ];
    }
}