<?php
namespace contact\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property string $Title
 * @property string $Pattern
 * @property string $UrlMask
 * @property bool $Visible
 *
 * Описание вспомогательных методов
 * @method ServiceType   with($condition = '')
 * @method ServiceType   find($condition = '', $params = [])
 * @method ServiceType   findByPk($pk, $condition = '', $params = [])
 * @method ServiceType   findByAttributes($attributes, $condition = '', $params = [])
 * @method ServiceType[] findAll($condition = '', $params = [])
 * @method ServiceType[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method ServiceType byId(int $id, bool $useAnd = true)
 * @method ServiceType byVisible(bool $visible, bool $useAnd = true)
 */
class ServiceType extends ActiveRecord
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
        return 'ContactServiceType';
    }
}