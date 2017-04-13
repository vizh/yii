<?php
namespace ict\models;

use application\components\ActiveRecord;

/**
 * @property integer $Id
 * @property string $Title
 * @property integer $Priority
 *
 * Описание вспомогательных методов
 * @method Role   with($condition = '')
 * @method Role   find($condition = '', $params = [])
 * @method Role   findByPk($pk, $condition = '', $params = [])
 * @method Role   findByAttributes($attributes, $condition = '', $params = [])
 * @method Role[] findAll($condition = '', $params = [])
 * @method Role[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Role byId(int $id, bool $useAnd = true)
 */
class Role extends ActiveRecord
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

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'IctRole';
    }
}