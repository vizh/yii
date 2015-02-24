<?php
namespace geo2\controllers;

use application\components\controllers\AjaxController as BaseAjaxController;
use geo2\models\City;

class AjaxController extends BaseAjaxController
{
    /**
     * Поиск по городам
     * @param string $term
     */
    public function actionCities($term)
    {
        $criteria = new \CDbCriteria();
        $criteria->with = ['Country', 'Region'];
        $criteria->order = '"t"."Priority" DESC, "t"."Name" ASC';
        $criteria->limit = 10;
        $cities = City::model()->byName($term)->findAll($criteria);
        $result = [];
        foreach ($cities as $city) {
            $result[] = $this->cityDataBuilder($city);
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     *
     * @param City $city
     * @return \stdClass
     */
    private function cityDataBuilder($city)
    {
        $result = new \stdClass();
        $result->CityId = $city->Id;
        $result->value = $result->Name = $city->Name;
        $result->RegionId = $city->RegionId;
        $result->CountryId = $city->CountryId;
        $result->label = $city->getAbsoluteName();
        return $result;
    }
}