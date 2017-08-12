<?php
namespace geo\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $ExtId
 * @property string $Name
 * @property int $Priority
 * @property bool $CitiesParsed
 *
 * Описание вспомогательных методов
 * @method Country   with($condition = '')
 * @method Country   find($condition = '', $params = [])
 * @method Country   findByPk($pk, $condition = '', $params = [])
 * @method Country   findByAttributes($attributes, $condition = '', $params = [])
 * @method Country[] findAll($condition = '', $params = [])
 * @method Country[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Country byId(int $id, bool $useAnd = true)
 * @method Country byExtId(int $id, bool $useAnd = true)
 * @method Country byName(string $name, bool $useAnd = true)
 * @method Country byCitiesParsed(bool $parsed = true, bool $useAnd = true)
 */
class Country extends ActiveRecord
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
        return 'GeoCountry';
    }
}