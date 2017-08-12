<?php
namespace raec\models;

use application\components\ActiveRecord;
use company\models\Company;

/**
 * @property int $Id
 * @property int $CompanyId
 * @property int $BriefId
 * @property bool $Primary
 *
 * @property Company $Company
 * @property Brief $Brief
 *
 * Описание вспомогательных методов
 * @method BriefLinkCompany   with($condition = '')
 * @method BriefLinkCompany   find($condition = '', $params = [])
 * @method BriefLinkCompany   findByPk($pk, $condition = '', $params = [])
 * @method BriefLinkCompany   findByAttributes($attributes, $condition = '', $params = [])
 * @method BriefLinkCompany[] findAll($condition = '', $params = [])
 * @method BriefLinkCompany[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method BriefLinkCompany byId(int $id, bool $useAnd = true)
 * @method BriefLinkCompany byCompanyId(int $id, bool $useAnd = true)
 * @method BriefLinkCompany byBriefId(int $id, bool $useAnd = true)
 * @method BriefLinkCompany byPrimary(bool $primary = true, bool $useAnd = true)
 */
class BriefLinkCompany extends ActiveRecord
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
        return 'RaecBriefLinkCompany';
    }

    public function relations()
    {
        return [
            'Brief' => [self::BELONGS_TO, '\raec\models\Brief', 'Id'],
            'Company' => [self::BELONGS_TO, '\company\models\Company', 'Id']
        ];
    }
}