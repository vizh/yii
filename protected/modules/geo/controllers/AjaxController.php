<?php
use application\components\controllers\AjaxController as TraitAjaxController;
use application\components\controllers\MainController;
use application\components\traits\LoadModelTrait;
use geo\models\City;
use geo\models\Region;
use application\components\utility\Texts;

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

        $criteria = new \CDbCriteria();
        $criteria->addCondition('"t"."Name" ILIKE :Name');
        $criteria->params['Name'] = Texts::prepareStringForLike($term) . '%';

        $regions = Region::model()->ordered()->limit(5)->with(['Country'])->findAll($criteria);
        foreach ($regions as $region) {
            $result[] = $region->jsonSerialize();
        }
        $this->returnJSON($result);
    }
}