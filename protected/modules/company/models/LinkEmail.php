<?php
namespace company\models;

use application\components\ActiveRecord;
use contact\models\Email;

/**
 * @property int $Id
 * @property int $CompanyId
 * @property int $EmailId
 *
 * @property Company $Company
 * @property Email $Email
 *
 * Описание вспомогательных методов
 * @method LinkEmail   with($condition = '')
 * @method LinkEmail   find($condition = '', $params = [])
 * @method LinkEmail   findByPk($pk, $condition = '', $params = [])
 * @method LinkEmail   findByAttributes($attributes, $condition = '', $params = [])
 * @method LinkEmail[] findAll($condition = '', $params = [])
 * @method LinkEmail[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LinkEmail byId(int $id, bool $useAnd = true)
 * @method LinkEmail byCompanyId(int $id, bool $useAnd = true)
 * @method LinkEmail byEmailId(int $id, bool $useAnd = true)
 */
class LinkEmail extends ActiveRecord
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
        return 'CompanyLinkEmail';
    }

    public function relations()
    {
        return [
            'Company' => [self::BELONGS_TO, '\company\models\Company', 'CompanyId'],
            'Email' => [self::BELONGS_TO, '\contact\models\Email', 'EmailId'],
        ];
    }
}
