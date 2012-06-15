<?php
AutoLoader::Import('library.rocid.geo.*');

class GeoCountrylist extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $countries = GeoCountry::GetAll();

    $countryData = array();
    foreach ($countries as $country)
    {
      $countryData[] = (object)array('Id' => $country->CountryId, 'Name' => $country->Name);
    }

    $this->SendJson($countryData);
  }
}
