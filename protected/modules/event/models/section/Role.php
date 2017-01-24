<?php
namespace event\models\section;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property string $Title
 * @property string $Type
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
 * @method Role byType(string $type, bool $useAnd = true)
 */
class Role extends ActiveRecord
{
    /**
     * @param string $className
     * @return Role
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventSectionRole';
    }
}