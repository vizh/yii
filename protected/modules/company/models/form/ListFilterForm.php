<?php
namespace company\models\form;

class ListFilterForm extends \CFormModel
{
    public $CityId;
    public $Query;

    public function rules()
    {
        return [
            ['CityId', 'numerical', 'allowEmpty' => true],
            ['Query', 'safe']
        ];
    }

    public function getCityList()
    {
        $cityList = [
            \Yii::t('app', 'Все города')
        ];

        $cities = \Yii::app()->db->createCommand()
            ->from(\company\models\Company::model()->tableName().' Company')
            ->selectDistinct('City.Id, City.Name, City.Priority')
            ->join(\company\models\LinkAddress::model()->tableName().' LinkAddress', '"Company"."Id" = "LinkAddress"."CompanyId"')
            ->join(\contact\models\Address::model()->tableName().' Address', '"Address"."Id" = "LinkAddress"."AddressId"')
            ->join(\geo\models\City::model()->tableName().' City', '"City"."Id" = "Address"."CityId"')
            ->order('City.Priority DESC, City.Name ASC')
            ->queryAll();

        foreach ($cities as $city) {
            $cityList[$city['Id']] = $city['Name'];
        }
        return $cityList;
    }
}
