<?php
AutoLoader::Import('library.rocid.geo.*');

class GeoCitylist extends AjaxNonAuthCommand
{
  protected function doExecute($regionId = '')
  {
//    if (! Lib::IsSelfReferer())
//    {
//      exit();
//    }
    $regionId = intval($regionId);
    $cities = GeoCity::GetCityByRegion($regionId);
    
    $cityData = array();
    foreach ($cities as $city)
    {
      $cityData[] = array('id' => $city->CityId, 'name' => $city->Name);
    }
    
    echo json_encode($cityData);
  }
}