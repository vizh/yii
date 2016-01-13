<?php
namespace geo\models;
use application\components\ActiveRecord;
use application\components\helpers\ArrayHelper;

/**
 * @property int $Id
 * @property int $ExtId
 * @property int $CountryId
 * @property string $Name
 * @property int $Priority
 * @property bool $CitiesParsed
 * @property bool $Error
 * @property bool $Start
 *
 * @property Country $Country
 *
 * @method Region find($condition='',$params=array())
 * @method Region findByPk($pk,$condition='',$params=array())
 * @method Region[] findAll($condition='',$params=array())
 * @method Region byCountryId($id)
 * @method Region byName($name)
 * @method Region ordered()
 * @method Region with(array)
 */
class Region extends ActiveRecord
{
    protected $defaultOrderBy = ['"t"."Priority"' => SORT_DESC, '"t"."Name"' => SORT_ASC];

    /**
     * @param string $className
     * @return Region
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'Geo2Region';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [
            'Country' => [self::BELONGS_TO, Country::className(), 'CountryId'],
        ];
    }

    /**
     * @return string
     */
    public function getAbsoluteName()
    {
        return $this->Country->Name.', ' . $this->Name;
    }

    /**
     * @inheritdoc
     */
    function jsonSerialize()
    {
        return ArrayHelper::toArray($this, [self::className() => [
            'RegionId' => 'Id', 'value' => 'Name', 'Name', 'CountryId', 'label' => function (Region $region) {
                return $region->getAbsoluteName();
            }
        ]]);
    }
}