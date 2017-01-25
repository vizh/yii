<?php
namespace raec\models;

use application\components\ActiveRecord;

/**
 * @property integer $Id
 * @property string $Title
 *
 * @property CompanyUser[] $CompanyUsers
 *
 * Описание вспомогательных методов
 * @method CompanyUserStatus   with($condition = '')
 * @method CompanyUserStatus   find($condition = '', $params = [])
 * @method CompanyUserStatus   findByPk($pk, $condition = '', $params = [])
 * @method CompanyUserStatus   findByAttributes($attributes, $condition = '', $params = [])
 * @method CompanyUserStatus[] findAll($condition = '', $params = [])
 * @method CompanyUserStatus[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method CompanyUserStatus byId(int $id, bool $useAnd = true)
 */
class CompanyUserStatus extends ActiveRecord
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
        return 'RaecCompanyUserStatus';
    }

    public function relations()
    {
        return [
            'CompanyUsers' => [self::HAS_MANY, 'RaecCompanyUser', 'StatusId'],
        ];
    }
}