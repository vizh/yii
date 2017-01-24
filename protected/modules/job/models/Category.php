<?php
namespace job\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property string $Title
 *
 * Описание вспомогательных методов
 * @method Category   with($condition = '')
 * @method Category   find($condition = '', $params = [])
 * @method Category   findByPk($pk, $condition = '', $params = [])
 * @method Category   findByAttributes($attributes, $condition = '', $params = [])
 * @method Category[] findAll($condition = '', $params = [])
 * @method Category[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Category byId(int $id, bool $useAnd = true)
 * @method Category byTitle(string $title, bool $useAnd = true)
 */
class Category extends ActiveRecord
{
    /**
     * @param string $className
     * @return Company
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'JobCategory';
    }
}