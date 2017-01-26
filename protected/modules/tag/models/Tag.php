<?php
namespace tag\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property string $Name
 * @property string $Title
 * @property bool $Verified
 *
 * Описание вспомогательных методов
 * @method Tag   with($condition = '')
 * @method Tag   find($condition = '', $params = [])
 * @method Tag   findByPk($pk, $condition = '', $params = [])
 * @method Tag   findByAttributes($attributes, $condition = '', $params = [])
 * @method Tag[] findAll($condition = '', $params = [])
 * @method Tag[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Tag byId(int $id, bool $useAnd = true)
 * @method Tag byName(string $name, bool $useAnd = true)
 * @method Tag byVerifed(bool $verifed = true, bool $useAnd = true)
 */
class Tag extends ActiveRecord
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
        return 'Tag';
    }
}
