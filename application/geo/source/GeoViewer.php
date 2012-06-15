<?php
AutoLoader::Import('library.rocid.geo.*');
 
class GeoViewer
{
  const ListCountry = 'country';
  const ListRegion = 'region';
  const ListCity = 'city';

  public static function GetCountriesSelect($selectedId = null, $name = 'country', $cssClass = null)
  {
    $countries = GeoCountry::GetAll();
    $list = array();
    $addressWords = Registry::GetWord('address');
    $list[] = array('id'=>0, 'name'=> $addressWords['option_country']);
    foreach($countries as $country)
    {
      $list[] = array('id'=>$country->CountryId, 'name' => $country->Name);
    }
    return self::getSelect($list, $selectedId, $name, $cssClass, 'country');
  }

  public static function GetRegionSelect($countryId = null, $selectedId = null, $name = 'region', $cssClass = null)
  {
    $regions = GeoRegion::GetRegionsByCountry($countryId);
    $list = array();
    $addressWords = Registry::GetWord('address');
    $list[] = array('id'=>0, 'name'=> $addressWords['option_region']);
    foreach($regions as $region)
    {
      $list[] = array('id'=>$region->RegionId, 'name' => $region->Name);
    }
    return self::getSelect($list, $selectedId, $name, $cssClass, 'region');
  }

  public static function GetCitySelect($regionId = null, $selectedId = null, $name = 'city', $cssClass = null)
  {
    $cities = GeoCity::GetCityByRegion($regionId);
    $list = array();
    $addressWords = Registry::GetWord('address');
    $list[] = array('id'=>0, 'name'=> $addressWords['option_city']);
    foreach($cities as $city)
    {
      $list[] = array('id'=>$city->RegionId, 'name' => $city->Name);
    }
    return self::getSelect($list, $selectedId, $name, $cssClass, 'city');
  }

  private static function getSelect($list, $selected, $name, $cssClass, $id)
  {
    $view = new View();
    $view->SetTemplate('select', 'geo', 'viewer', '', 'public');
    $view->List = $list;
    $view->Selected = $selected;
    $view->Name = $name;
    $view->CssClass = $cssClass;
    $view->Id = $id;

    return $view;
  }
}
