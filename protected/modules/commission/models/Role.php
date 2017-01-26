<?php
namespace commission\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property string $Title
 * @property int $Priority
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
 * @method Role byTitle(string $title, bool $useAnd = true)
 * @method Role byPriority(int $int, bool $useAnd = true)
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

    public function tableName()
    {
        return 'CommissionRole';
    }
}
