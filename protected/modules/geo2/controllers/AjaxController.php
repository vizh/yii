<?php
namespace geo2\controllers;

use application\components\controllers\AjaxController as TraitAjaxController;
use application\components\controllers\MainController;
use geo2\models\City;

class AjaxController extends MainController
{
    use TraitAjaxController;

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
            $result[] = $city->getAjaxAttributes();
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}