<?php
AutoLoader::Import('library.rocid.geo.*');

class GeoRegionlist extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $countryId = Registry::GetRequestVar('CountryId', 0);
    $regions = GeoRegion::GetRegionsByCountry($countryId);

    $regionData = array();
    foreach ($regions as $region)
    {
      $regionData[] = (object)array('Id' => $region->RegionId, 'Name' => $region->Name);
    }


    $this->SendJson($regionData);
  }
}
