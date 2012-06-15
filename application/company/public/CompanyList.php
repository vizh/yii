<?php
AutoLoader::Import('library.rocid.company.*');
AutoLoader::Import('library.rocid.geo.*');

class CompanyList extends GeneralCommand
{
  protected function preExecute()
  {
    parent::preExecute();    
    //Установка хеадера    
    $this->view->HeadScript(array('src'=>'/js/geodropdown.js'));
    $this->view->HeadScript(array('src'=>'/js/functions.js'));
    
    $titles = Registry::GetWord('titles'); 
    $this->SetTitle($titles['company_list']);
  }  
  
  protected function doExecute($letter = '', $location = '0-0-0', $page = '1')
  {
    $letter = $this->parseLetter($letter);
    $location = $this->parseLocation($location);
    $companyList = Company::GetCompanyList($letter, $location, intval($page));
    $companies = $companyList['companies'];
    $count = $companyList['count'];    
    
    $jsCode = $this->getJsCode($letter, $location);
    $this->view->HeadScript(array('script' => $jsCode));
    
    $this->view->Country = $this->getCountryHtml($location);
    $this->view->Region = $this->getRegionHtml($location);
    $this->view->City = $this->getCityHtml($location);
    
    $this->view->Companies = $this->getCompaniesHtml($companies);
    
    $this->view->Paginator = $this->getPaginator($letter, $location, $page, $count);
    
    echo $this->view;
  }
  
  private function parseLetter($letter)
  {
    if (Lib::DetectUTF8($letter))
    {
      $letter = urldecode($letter);
    }
    if ($letter == '' || (! in_array($letter, Consts::$latChars) && !in_array($letter, Consts::$rusChars))) 
    {
      $letter = 'all';
    }
    return $letter;
  }
  private function parseLocation($location)
  {
    //$location = '9908-9964-9977';
    //$location = '3159-0-0';
    $parts = preg_split('/-/', trim($location), -1, PREG_SPLIT_NO_EMPTY);
    $location = array('country' => 0, 'region' => 0, 'city' => 0);
    if (isset($parts[0]) && intval($parts[0]) != 0)
    {
      $location['country'] = intval($parts[0]);
      if (isset($parts[1]) && intval($parts[1]) != 0)
      {
        $location['region'] = intval($parts[1]);
        if (isset($parts[2]) && intval($parts[2]) != 0)
        {
          $location['city'] = intval($parts[2]);
        }
      }
    }
    
    return $location;
  }
  
  private function getJsCode($letter, $location)
  {
    $view = new View();
    $view->SetTemplate('jscode');
    $view->Letter = $letter;
    $view->Url = '/company/list';
    
    return $view;
  }
  
  private function getCountryHtml($location)
  {
    $countries = GeoCountry::GetAll();
    if (! empty($countries))
    {
      $result = new ViewContainer();
      
      $view = new View();
      $view->SetTemplate('option');
      $view->Value = 0;
      $addressWords = Registry::GetWord('address'); 
      $view->Name = $addressWords['option_country'];
      if ($location['country'] == 0)
      {
        $view->Selected = 'selected="selected"';
      }
      $result->AddView($view);
      
      foreach ($countries as $country)
      {
        $view = new View();
        $view->SetTemplate('option');
        $view->Value = $country->CountryId;
        $view->Name = $country->Name;
        if ($location['country'] == $country->CountryId)
        {
          $view->Selected = 'selected="selected"';
        }
        
        $result->AddView($view);
      }
      
      return $result;
    }
    
    return '';
  }
  
  private function getRegionHtml($location)
  {
    $result = new ViewContainer();
    
    $view = new View();
    $view->SetTemplate('option');
    $view->Value = 0;
    $addressWords = Registry::GetWord('address'); 
    $view->Name = $addressWords['option_region'];
    if ($location['region'] == 0)
    {
      $view->Selected = 'selected="selected"';
    }
    $result->AddView($view);
    
    if ($location['country'] != 0)
    {
      $regions = GeoRegion::GetRegionsByCountry($location['country']);
      if (! empty($regions))
      {
        foreach ($regions as $region)
        {
          $view = new View();
          $view->SetTemplate('option');
          $view->Value = $region->RegionId;
          $view->Name = $region->Name;
          if ($location['region'] == $region->RegionId)
          {
            $view->Selected = 'selected="selected"';
          }
          
          $result->AddView($view);
        }
      }
    }
    
    return $result;
  }
  
  private function getCityHtml($location)
  {
    $result = new ViewContainer();
    
    $view = new View();
    $view->SetTemplate('option');
    $view->Value = 0;
    $addressWords = Registry::GetWord('address'); 
    $view->Name = $addressWords['option_city'];
    if ($location['city'] == 0)
    {
      $view->Selected = 'selected="selected"';
    }
    $result->AddView($view);
    
    if ($location['region'] != 0)
    {
      $cities = GeoCity::GetCityByRegion($location['region']);
      if (! empty($cities))
      {
        foreach ($cities as $city)
        {
          $view = new View();
          $view->SetTemplate('option');
          $view->Value = $city->CityId;
          $view->Name = $city->Name;
          if ($location['city'] == $city->CityId)
          {
            $view->Selected = 'selected="selected"';
          }
          
          $result->AddView($view);
        }
      }
    }
    
    return $result;
  }
    
  private function getCompaniesHtml($companies)
  {
    if (! empty($companies))
    {
      $container = new ViewContainer();
      $flag = false;
      foreach ($companies as $company)
      {
        $view = new View();
        $view->SetTemplate('company');
        
        $view->CompanyId = $company->GetCompanyId();
        $view->Name = $company->GetName();
        $view->FullName = $company->GetFullName();
        $view->Logo = $company->GetMiniLogo();        
        
        $container->AddView($view);
        if ($flag)
        {            
          $empty = new View();
          $empty->SetTemplate('company');
          $empty->Empty = true;
          $container->AddView($empty);
          $flag = false;
        }
        else
        {
          $flag = true;
        }
      }
      
      return $container;
    }
    
    return '';
  }
  
  private function getPaginator($letter, $location, $page, $count)
  {
    $userPerPage = SettingManager::GetSetting('UserPerPage');
    $url = '/company/list/' . $letter . '/' . $location['country'] . '-' . $location['region'] . '-' . $location['city'] . '/%s/';
    $paginator = new Paginator($url, $page, $userPerPage, $count);
    return $paginator;
  }
}

/**
|---------------------------------------------------------------
| ГЕНЕРАЦИЯ СПИСКА СТРАН
|---------------------------------------------------------------

function getCountryList($countryId = 0) {
  
  global $DB, $queryCache;
  
  $data = array('0' => '- Выберите страну -');
  $qCountries = $DB->query(sprintf($queryCache['getLocation'], '*', '`country`', '1', '`priority` DESC, `name`', 999));
  if ($DB->num_rows() > 0) {
    while (($country = $DB->fetch_object($qCountries)) ) $data[$country->country_id] = $country->name;
  }
  return getHTMLSelect('country', 'country', $data, $countryId);

}
*/

/*
|---------------------------------------------------------------
| ГЕНЕРАЦИЯ СПИСКА РЕГИОНОВ
|---------------------------------------------------------------

function getRegionList($onlyItems = false, $countryId = 0, $regionId = 0, $json = false) {

  global $DB, $queryCache;
  
  $data = array('0' => '- Выберите регион -');
  $limit = ($countryId == 0) ? 0 : 999;
  if ($json) $json_data = '';
  
  $qRegions = $DB->query(sprintf($queryCache['getLocation'], '*', '`region`', '`country_id` = ' . $countryId, '`priority` DESC, `name`', $limit));
  if ($DB->num_rows() > 0) {
    while (($region = $DB->fetch_object($qRegions)) ) {
      if ($json) $json_data .= '{"id":"' . $region->region_id . '", "name":"' . $region->name . '"},';
     $data[$region->region_id] = $region->name;
    }
  }
  
  if (!$json)
    return getHTMLSelect('region', 'region', $data, $regionId, false, $onlyItems);
  else
    return '{"regions":[' . $json_data . ']}';
  
}

*/

/**
|---------------------------------------------------------------
| ГЕНЕРАЦИЯ СПИСКА ГОРОДОВ
|---------------------------------------------------------------

function getCityList($onlyItems = false, $regionId = 0, $cityId = 0, $json = false) {

  global $DB, $queryCache;
  
  $data = array('0' => '- Выберите город -');
  $limit = ($regionId == 0) ? 0 : 999;
  if ($json) $json_data = '';
  
  $qCities = $DB->query(sprintf($queryCache['getLocation'], '*', '`city`', '`region_id` = ' . $regionId, '`priority` DESC,`name`', $limit));
  if ($DB->num_rows() > 0) {
    while (($city = $DB->fetch_object($qCities)) ) {
      if ($json) $json_data .= '{"id":"' . $city->city_id . '", "name":"' . $city->name . '"},';
      $data[$city->city_id] = $city->name;
    }
  }
  
  if (!$json)
    return getHTMLSelect('city', 'city', $data, $cityId, false, $onlyItems);
  else
    return '{"cities":[' . $json_data . ']}';
  
}


  $type = getGPC('type', '');
  $id = intval(getGPC('id', 0));

  switch ($type) {
    case 'region':
      $out = getRegionList(true, $id, 0, true);
    break;
    case 'city':
      $out = getCityList(true, $id, 0, true);
    break;
  }
  
  print $out;


*/