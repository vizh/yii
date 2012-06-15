<?php
AutoLoader::Import('library.rocid.geo.*');

class GeoCitylist extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $regionId = Registry::GetRequestVar('RegionId', 0);
    $cities = GeoCity::GetCityByRegion($regionId);

    $cityData = array();
    foreach ($cities as $city)
    {
      $cityData[] = (object)array('Id' => $city->CityId, 'Name' => $city->Name);
    }

    $this->SendJson($cityData);
  }
}
