<?php
use application\components\controllers\AjaxController as TraitAjaxController;
use application\components\controllers\MainController;
use application\components\traits\LoadModelTrait;
use contact\models\Address;
use geo\models\City;
use geo\models\Region;

class AjaxController extends MainController
{
    use TraitAjaxController;
    use LoadModelTrait;

    /**
     * Воввращает информацию по городу
     * @param int $id
     * @throws \CHttpException
     * @throws \application\components\Exception
     */
    public function actionCity($id)
    {
        /** @var City $city */
        $city = $this->loadModel(City::className(), $id);
        $this->returnJSON($city->jsonSerialize());
    }

    /**
     * Возвращает информацию по региону
     * @param int $id
     * @throws CHttpException
     * @throws \application\components\Exception
     */
    public function actionRegion($id)
    {
        /** @var Region $region */
        $region = $this->loadModel(Region::className(), $id);
        $this->returnJSON($region->jsonSerialize());
    }

    /**
     * Поиск по городам и регионам
     * @param string $term
     */
    public function actionSearch($term)
    {
        $result = [];

        $cities = City::model()->byName($term)->ordered()->limit(5)->with(['Country', 'Region'])->findAll();
        foreach ($cities as $city) {
            $result[] = $city->jsonSerialize();
        }

        $regions = Region::model()->byName($term)->ordered()->limit(5)->with(['Country'])->findAll();
        foreach ($regions as $region) {
            $result[] = $region->jsonSerialize();
        }
        $this->returnJSON($result);
    }

    /**
     * Получение координат на карте по адресу-строке
     */
    public function actionGetCoordinatesByAddress()
    {
        $request = \Yii::app()->getRequest();

        $geocode = null;
        if ($request->isPostRequest) {
            $geocode = $request->getParam('geocode');
            if (!empty($geocode)) {
                $geoCoordinates = Address::defineGeoPointCoordinates($geocode);
            }

            if (empty($geoCoordinates)) {
                $res = [
                    'status' => 'error',
                    'msg' => \Yii::t('app', 'Не удается получить координаты места автоматически. '.
                        'Пожалуйста, отметьте маркером место вручную.')
                ];
            } else {
                $res = ['status' => 'success', 'coordinates' => [$geoCoordinates[1], $geoCoordinates[0]]];
            }
        } else {
            $res = ['status' => 'error', 'msg' => \Yii::t('app', 'Не задан адрес для получения координат')];
        }
        echo CJSON::encode($res);
    }
}