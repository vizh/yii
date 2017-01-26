<?php
namespace event\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $FirstPurposeId
 * @property int $SecondPurposeId
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
 * @method Purpose byFirstPurposeId(int $id, bool $useAnd = true)
 * @method Purpose bySecondPurposeId(int $id, bool $useAnd = true)
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
        return 'EventPurposeLink';
    }
}