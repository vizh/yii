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
 * @method Country find($condition='',$params=array())
 * @method Country findByPk($pk,$condition='',$params=array())
 * @method Country[] findAll($condition='',$params=array())
 * @method Country byExtId($id)
 */
class Country extends ActiveRecord
{
    /**
     * @param string $className
     * @return Country
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'GeoCountry';
    }

    public function primaryKey()
    {
        return 'Id';
    }
}