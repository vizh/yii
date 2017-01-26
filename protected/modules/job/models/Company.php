<?php
namespace job\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property string $Name
 * @property string $LogoUrl
 *
 * Описание вспомогательных методов
 * @method Company   with($condition = '')
 * @method Company   find($condition = '', $params = [])
 * @method Company   findByPk($pk, $condition = '', $params = [])
 * @method Company   findByAttributes($attributes, $condition = '', $params = [])
 * @method Company[] findAll($condition = '', $params = [])
 * @method Company[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Company byId(int $id, bool $useAnd = true)
 * @method Company byName(string $name, bool $useAnd = true)
 */
class Company extends ActiveRecord
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
        return 'JobCompany';
    }
}
