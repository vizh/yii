<?php
namespace geo\models;

use application\components\ActiveRecord;
use application\components\helpers\ArrayHelper;
use application\components\utility\Texts;

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
 * Описание вспомогательных методов
 * @method Region   with($condition = '')
 * @method Region   find($condition = '', $params = [])
 * @method Region   findByPk($pk, $condition = '', $params = [])
 * @method Region   findByAttributes($attributes, $condition = '', $params = [])
 * @method Region[] findAll($condition = '', $params = [])
 * @method Region[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Region byId(int $id, bool $useAnd = true)
 * @method Region byExtId(int $id, bool $useAnd = true)
 * @method Region byCountryId(int $id, bool $useAnd = true)
 */
class Region extends ActiveRecord
{
    protected $defaultOrderBy = ['"t"."Priority"' => SORT_DESC, '"t"."Name"' => SORT_ASC];

    /**
     * @param string $className
     * @return Region
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'GeoRegion';
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
        return $this->Country->Name.', '.$this->Name;
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

    /**
     * @inheritdoc
     */
    function jsonSerialize()
    {
        return ArrayHelper::toArray($this, [
            self::className() => [
                'RegionId' => 'Id',
                'value' => 'Name',
                'Name',
                'CountryId',
                'label' => function (Region $region) {
                    return $region->getAbsoluteName();
                }
            ]
        ]);
    }
}