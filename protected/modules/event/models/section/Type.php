<?php
namespace event\models\section;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property string $Title
 * @property string $Code
 *
 * Описание вспомогательных методов
 * @method Type   with($condition = '')
 * @method Type   find($condition = '', $params = [])
 * @method Type   findByPk($pk, $condition = '', $params = [])
 * @method Type   findByAttributes($attributes, $condition = '', $params = [])
 * @method Type[] findAll($condition = '', $params = [])
 * @method Type[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Type byId(int $id, bool $useAnd = true)
 * @method Type byCode(string $code, bool $useAnd = true)
 */
class Type extends ActiveRecord
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
        return 'EventSectionType';
    }
}