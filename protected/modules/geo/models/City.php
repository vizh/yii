<?php
namespace geo\models;

use application\components\helpers\ArrayHelper;
use application\components\utility\Texts;
use application\models\translation\ActiveRecord;
use application\widgets\IAutocompleteItem;

/**
 * @property int $Id
 * @property int $ExtId
 * @property int $CountryId
 * @property int $RegionId
 * @property int $Name
 * @property string $Area
 * @property int $Priority
 * @property bool $Parsed
 *
 * @property Country $Country
 * @property Region $Region
 *
 * @method City find($condition='',$params=array())
 * @method City findByPk($pk,$condition='',$params=array())
 * @method City[] findAll($condition='',$params=array())
 * @method City byRegionId($id)
 * @method City byCountryId($id)
 * @method City ordered()
 * @method City with(array)
 */
class City extends ActiveRecord
{
    protected $defaultOrderBy = ['"t"."Priority"' => SORT_DESC, '"t"."Name"' => SORT_ASC];

    /**
     * @param string $className
     * @return City
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'Geo2City';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [
            'Country' => [self::BELONGS_TO, Country::className(), 'CountryId'],
            'Region' => [self::BELONGS_TO, Region::className(), 'RegionId']
        ];
    }

    /**
     * @return string[]
     */
    public function getTranslationFields()
    {
        return ['Name'];
    }

    /**
     * @param string $name
     * @param bool $useAnd
     * @return $this
     */
    public function byName($name, $useAnd = true)
    {
        $name = Texts::prepareStringForTsvector($name);
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."SearchName" @@ to_tsquery(:Name)';
        $criteria->params = ['Name' => $name];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    public function getAbsoluteName()
    {
        $result = $this->Country->Name.', ';
        if ($this->RegionId != null) {
            $result .= $this->Region->Name.', ';
        }
        return $result . $this->Name;
    }

    /**
     * @inheritdoc
     */
    function jsonSerialize()
    {
        return ArrayHelper::toArray($this, [City::className() => [
            'CityId' => 'Id', 'value' => 'Name', 'Name', 'RegionId', 'CountryId', 'label' => function (City $city) {
                return $city->getAbsoluteName();
            }
        ]]);
    }
}