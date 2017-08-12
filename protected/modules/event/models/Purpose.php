<?php
namespace event\models;

use application\components\ActiveRecord;

/**
 * @package event\models
 * @property int $Id
 * @property string $Title
 * @property bool $Visible
 *
 * Описание вспомогательных методов
 * @method Purpose   with($condition = '')
 * @method Purpose   find($condition = '', $params = [])
 * @method Purpose   findByPk($pk, $condition = '', $params = [])
 * @method Purpose   findByAttributes($attributes, $condition = '', $params = [])
 * @method Purpose[] findAll($condition = '', $params = [])
 * @method Purpose[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Purpose byId(int $id, bool $useAnd = true)
 * @method Purpose byVisible(bool $visible = true, bool $useAnd = true)
 */
class Purpose extends ActiveRecord
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
        return 'EventPurpose';
    }
}