<?php
namespace geo\models;

use application\components\helpers\ArrayHelper;
use application\components\utility\Texts;
use application\models\translation\ActiveRecord;

/**
 * @property int $Id
 * @property int $ExtId
 * @property int $CountryId
 * @property int $RegionId
 * @property string $Name
 * @property string $Area
 * @property int $Priority
 * @property bool $Parsed
 *
 * @property Country $Country
 * @property Region $Region
 *
 * Описание вспомогательных методов
 * @method City   with($condition = '')
 * @method City   find($condition = '', $params = [])
 * @method City   findByPk($pk, $condition = '', $params = [])
 * @method City   findByAttributes($attributes, $condition = '', $params = [])
 * @method City   ordered()
 * @method City[] findAll($condition = '', $params = [])
 * @method City[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method City byId(int $id, bool $useAnd = true)
 * @method City byExtId(int $id, bool $useAnd = true)
 * @method City byCountryId(int $id, bool $useAnd = true)
 * @method City byRegionId(int $id, bool $useAnd = true)
 * @method City byParsed(bool $parsed, bool $useAnd = true)
 *
 */
class City extends ActiveRecord
{
    protected $defaultOrderBy = ['"t"."Priority"' => SORT_DESC, '"t"."Name"' => SORT_ASC];

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
        return 'GeoCity';
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

        return $result.$this->Name;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return ArrayHelper::toArray($this, [
            City::className() => [
                'CityId' => 'Id',
                'value' => 'Name',
                'Name',
                'RegionId',
                'CountryId',
                'label' => function (City $city) {
                    return $city->getAbsoluteName();
                }
            ]
        ]);
    }
}