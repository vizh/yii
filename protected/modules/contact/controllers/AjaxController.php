<?php
class AjaxController extends \CController
{
  /**
   * Поиск по городам и регионам
   * @para string $term
   */
  public function actionSearch($term)
  {
    $criteria = new \CDbCriteria();
    $criteria->with = array('Country', 'Region');
    $criteria->order = '"Country"."Priority" DESC, "Region"."Priority" DESC,"t"."Priority" DESC, "t"."Name" ASC';
    $criteria->limit = 10;
    $criteria->addCondition('"t"."Name" ILIKE :Name');
    $criteria->params['Name'] = '%'.$term.'%';
    $cities = \geo\models\City::model()->findAll($criteria);
    $result = array();
    foreach ($cities as $city)
    {
      $result[] = $this->cityDataBuilder($city);
    }
    
    $criteria->with = array('Country');
    $criteria->order = '"Country"."Priority" DESC, "t"."Priority" DESC, "t"."Name" ASC';
    $regions = \geo\models\Region::model()->findAll($criteria);
    foreach ($regions as $region)
    {
      $result[] = $this->regionDataBuilder($region);
    }
    
    echo json_encode($result);
  }
  
  /**
   * Поиск города по Id
   * @param int $cityId
   * @throws \CHttpException
   */
  public function actionCity($cityId)
  {
    $criteria = new \CDbCriteria();
    $criteria->with  = array('Country', 'Region');
    $city = \geo\models\City::model()->findByPk($cityId, $criteria);
    if ($city == null)
    {
      throw new \CHttpException(404);
    }
    $result = $this->cityDataBuilder($city);
    echo json_encode($result);
  }
  
  /**
   * Поиск региона по Id
   * @param int $regionId
   * @throws \CHttpException
   */
  public function actionRegion($regionId)
  {
    $criteria = new \CDbCriteria();
    $criteria->with  = array('Country');
    $region = \geo\models\Region::model()->findByPk($regionId, $criteria);
    if ($region == null)
    {
      throw new \CHttpException(404);
    }
    $result = $this->regionDataBuilder($region);
    echo json_encode($result);
  }
  
  /**
   * 
   * @param \geo\models\City $city
   * @return \stdClass
   */
  private function cityDataBuilder($city)
  {
    $result = new \stdClass();
    $result->CityId = $city->Id;
    $result->value = $result->Name = $city->Name;
    $result->RegionId = $city->RegionId;
    $result->CountryId = $city->CountryId;
    $result->label = $city->Country->Name.', '.$city->Region->Name.', '.$city->Name;
    return $result;
  }
  
  /**
   * 
   * @param \geo\models\Region $region
   * @return \stdClass
   */
  private function regionDataBuilder($region)
  {
    $result = new \stdClass();
    $result->value = $result->Name = $region->Name;
    $result->RegionId = $region->Id;
    $result->CountryId = $region->CountryId;
    $result->label = $region->Country->Name.', '.$region->Name;
    return $result;
  }
}
