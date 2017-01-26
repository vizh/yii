<?php
namespace job\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property string $Title
 *
 * Описание вспомогательных методов
 * @method Position   with($condition = '')
 * @method Position   find($condition = '', $params = [])
 * @method Position   findByPk($pk, $condition = '', $params = [])
 * @method Position   findByAttributes($attributes, $condition = '', $params = [])
 * @method Position[] findAll($condition = '', $params = [])
 * @method Position[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Position byId(int $id, bool $useAnd = true)
 * @method Position byTitle(string $title, bool $useAnd = true)
 */
class Position extends ActiveRecord
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
        return 'JobPosition';
    }
}