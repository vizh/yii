<?php
namespace company\models;

use application\components\ActiveRecord;
use contact\models\Site;

/**
 * @property int $Id
 * @property int $CompanyId
 * @property int $SiteId
 *
 * @property Company $Company
 * @property Site $Site
 *
 * Описание вспомогательных методов
 * @method LinkSite   with($condition = '')
 * @method LinkSite   find($condition = '', $params = [])
 * @method LinkSite   findByPk($pk, $condition = '', $params = [])
 * @method LinkSite   findByAttributes($attributes, $condition = '', $params = [])
 * @method LinkSite[] findAll($condition = '', $params = [])
 * @method LinkSite[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LinkSite byId(int $id, bool $useAnd = true)
 * @method LinkSite byCompanyId(int $id, bool $useAnd = true)
 * @method LinkSite bySiteId(int $id, bool $useAnd = true)
 */
class LinkSite extends ActiveRecord
{
    /**
     * @param string $className
     * @return LinkSite
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'CompanyLinkSite';
    }

    public function relations()
    {
        return [
            'Company' => [self::BELONGS_TO, '\company\models\Company', 'CompanyId'],
            'Site' => [self::BELONGS_TO, '\contact\models\Site', 'SiteId'],
        ];
    }
}