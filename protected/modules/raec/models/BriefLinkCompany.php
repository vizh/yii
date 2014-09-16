<?php
namespace raec\models;
use company\models\Company;

/**
 * Class BriefLinkCompany
 * @property int $Id
 * @property int $CompanyId
 * @property int $BriefId
 * @property bool $Primary
 * @property Company $Company
 * @property Brief $Brief
 * @package raec\models
 */
class BriefLinkCompany extends \CActiveRecord
{
    /**
     * @param string $className
     * @return BriefLinkCompany
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'RaecBriefLinkCompany';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [
            'Brief' => [self::BELONGS_TO, '\raec\models\Brief', 'Id'],
            'Company' => [self::BELONGS_TO, '\company\models\Company', 'Id']
        ];
    }
} 