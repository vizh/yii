<?php
class GeoController  extends convert\components\controllers\Controller 
{
  public function actionCity()
  {
    $cities = $this->queryAll('SELECT * FROM `GeoCity` ORDER BY `CityId` ASC');
    foreach ($cities as $city)
    {
      $newCity = new \geo\models\City();
      $newCity->Id = $city['CityId'];
      $newCity->CountryId = $city['CountryId'];
      $newCity->RegionId = $city['RegionId'];
      $newCity->Name = $city['Name'];
      $newCity->Priority = $city['Priority'];
      $newCity->save();
    }
  }
  
  public function actionCountry()
  {
    $countries = $this->queryAll('SELECT * FROM `GeoCountry` ORDER BY `CountryId` ASC');
    foreach ($countries as $country)
    {
      $newCountry = new \geo\models\Country();
      $newCountry->Id = $country['CountryId'];
      $newCountry->Name = $country['Name'];
      $newCountry->Priority = $country['Priority'];
      $newCountry->save();
    }
  }
  
  public function actionRegion()
  {
    $regiones = $this->queryAll('SELECT * FROM `GeoRegion` ORDER BY `RegionId` ASC');
    foreach ($regiones as $region)
    {
      $newRegion = new \geo\models\Region();
      $newRegion->Id = $region['RegionId'];
      $newRegion->CountryId = $region['CountryId'];
      $newRegion->Name = $region['Name'];
      $newRegion->Priority = $region['Priority'];
      $newRegion->save();
    }
  }
}
