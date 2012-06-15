<?php
AutoLoader::Import('library.rocid.company.*');

class CompanyEdit extends GeneralCommand
{
  /**
	 * @var Company
	 */
  private $company;

  protected function preExecute()
  {
    parent::preExecute();
    //Установка хеадера
    //		$this->view->HeadLink(array('href'=>'/css/company.css', 'rel'=>'stylesheet', 'type'=>'text/css'));

    $this->view->HeadScript(array('src'=>'/js/libs/jquery.simplemodal.1.4.1.min.js'));
    $this->view->HeadScript(array('src'=>'/js/libs/jquery-ui-1.8.16.custom.min.js'));
    $this->view->HeadScript(array('src'=>'/js/libs/jquery.ajaxfileupload.js'));
    $this->view->HeadScript(array('src'=>'/js/libs/jquery.imgareaselect.min.js'));
    $this->view->HeadScript(array('src'=>'/js/company.edit.js'));
    $this->view->HeadScript(array('src'=>'/js/geodropdown.js'));
    $this->view->HeadScript(array('src'=>'/js/functions.js'));

    $this->view->HeadLink(array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => '/css/blitzer/jquery-ui-1.8.16.custom.css'));

    $titles = Registry::GetWord('titles');
    $this->SetTitle($titles['general']);
  }

  protected function doExecute($companyId = '')
  {
    $companyId = intval($companyId);

    $this->company = Company::GetById($companyId, Company::LoadContactInfo);

    if (empty($this->company) || $this->LoginUser == null
        || (!$this->LoginUser->IsHaveAdminPermissions() && !$this->company->IsEditor($this->LoginUser)))
    {
      Lib::Redirect('/');
    }



    $this->view->CompanyId = $companyId;
    $this->view->MainEdit = $this->GetMainEditHtml();
    $this->view->ContactEdit = $this->GetContactEditHtml();
    $this->view->AddressEdit = $this->GetAddressEditHtml();
    $this->view->LogoEdit = $this->GetLogoEditHtml();

    echo $this->view;

  }

  protected function GetMainEditHtml()
  {

    $view = new View();
    $view->SetTemplate('main');

    $view->Name = $this->company->GetName();
    $view->FullName = $this->company->GetFullName();
    $view->Info = $this->company->GetInfo();

    return $view;

  }

  protected function GetContactEditHtml() {

    $view = new View();
    $view->SetTemplate('contact');

    // Emails
    $emails = $this->company->GetEmails();
    if (!empty($emails)) {
      $view->EmailId = $emails[0]->EmailId;
      $view->Email = $emails[0]->Email;
    }

    // Sites
    $sites = $this->company->GetSites();
    if (!empty($sites)) {
      $view->Site = $sites[0]->Url;
    }

    // Телефоны
    $phones = $this->company->GetPhones();
    $phonesContainer = new ViewContainer();
    $flag = true;
    foreach ($phones as $phone) {
      $phoneView = new View();
      $phoneView->SetTemplate('phone');
      $phoneView->Id = $phone->PhoneId;
      $phoneView->Phone = $phone->Phone;
      $phoneView->Type = $phone->Type;
      if ($flag)
      {
        $phoneView->FirstPhone = true;
        $flag = false;
      }

      $phonesContainer->AddView($phoneView);
    }
    $phoneView = new View();
    $phoneView->SetTemplate('phone');
    $phoneView->Empty = true;
    $phonesContainer->AddView($phoneView);
    $view->Phones = $phonesContainer;

    return $view;

  }

  protected function GetAddressEditHtml() {

    $view = new View();
    $view->SetTemplate('address');

    $address = $this->company->GetAddress();
    $view->Countries = GeoCountry::GetAll();
    $view->Regions = array();
    $view->Cities = array();
    if ($address != null)
    {
      $city = $address->City(array('with'=> array('Country', 'Region')));
      if ($city != null)
      {
        $view->CountryId = $city->Country->CountryId;
        $view->RegionId = $city->Region->RegionId;
        $view->CityId = $city->CityId;

        $view->Regions = GeoRegion::GetRegionsByCountry($city->Country->CountryId);
        $view->Cities = GeoCity::GetCityByRegion($city->Region->RegionId);
      }

      $view->PostalIndex = $address->PostalIndex;
      $view->Street = $address->Street;
      $view->House = $address->GetHouseParsed();
      $view->Apartment = $address->Apartment;
    }

    return $view;

  }

  protected function GetLogoEditHtml() {

    $view = new View();
    $view->SetTemplate('logo');

    $view->Logo = $this->company->GetLogo();
    $view->MiniLogo = $this->company->GetMiniLogo();

    return $view;

  }


}