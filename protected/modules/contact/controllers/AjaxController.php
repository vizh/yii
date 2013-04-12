<?php
class AjaxController extends \CController
{
  public function actionCountries()
  {
    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."Priority" DESC, "t"."Name" ASC';
    $countries = \geo\models\Country::model()->findAll($criteria);
    echo json_encode(\CHtml::listData($countries, 'Id', 'Name'));
    \Yii::app()->end();
  }
  
  public function actionRegions($countryId)
  {
    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."Priority" DESC, "t"."Name" ASC';
    $criteria->condition = '"t"."CountryId" = :CountryId';
    $criteria->params['CountryId'] = $countryId; 
    $regions = \geo\models\Region::model()->findAll($criteria);
    echo json_encode(\CHtml::listData($regions, 'Id', 'Name'));
    \Yii::app()->end();
  }
  
  public function actionCities($regionId)
  {
    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."Priority" DESC, "t"."Name" ASC';
    $criteria->condition = '"t"."RegionId" = :RegionId';
    $criteria->params['RegionId'] = $regionId; 
    $cities = \geo\models\City::model()->findAll($criteria);
    echo json_encode(\CHtml::listData($cities, 'Id', 'Name'));
    \Yii::app()->end();
  }
}
