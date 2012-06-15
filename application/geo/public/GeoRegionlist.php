<?php
AutoLoader::Import('library.rocid.geo.*');

class GeoRegionlist extends AjaxNonAuthCommand
{
  protected function doExecute($countryId = '')
  {
//    if (! Lib::IsSelfReferer())
//    {
//      exit();
//    }
    $countryId = intval($countryId);
    $regions = GeoRegion::GetRegionsByCountry($countryId);
    
    $regionData = array();
    foreach ($regions as $region)
    {
      $regionData[] = array('id' => $region->RegionId, 'name' => $region->Name);
    }
    
    echo json_encode($regionData);
  }
}