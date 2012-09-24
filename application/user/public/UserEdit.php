<?php
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.social.*');

class UserEdit extends GeneralCommand
{
	/**
	 * @var User
	 */
	private $user = null;

	protected function preExecute()
	{
		parent::preExecute();
		
		$this->view->HeadScript(array('src'=>'/js/libs/jquery.simplemodal.1.4.1.min.js'));
		$this->view->HeadScript(array('src'=>'/js/libs/jquery-ui-1.8.16.custom.min.js'));
		$this->view->HeadScript(array('src'=>'/js/libs/jquery.ajaxfileupload.js'));
		$this->view->HeadScript(array('src'=>'/js/libs/jquery.imgareaselect.min.js'));
    $this->view->HeadScript(array('src'=>'/js/social.js'));
		$this->view->HeadScript(array('src'=>'/js/user.edit.js?1.1.3'));
		$this->view->HeadScript(array('src'=>'/js/geodropdown.js'));
		$this->view->HeadScript(array('src'=>'/js/functions.js'));


		$this->view->HeadLink(array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => '/css/blitzer/jquery-ui-1.8.16.custom.css'));
		$this->view->HeadLink(array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => '/css/imgareaselect/imgareaselect.css'));

		$titles = Registry::GetWord('titles');
		$this->SetTitle($titles['useredit']);
	}

	protected function doExecute()
	{
		if ($this->LoginUser == null)
		{
			Lib::Redirect(RouteRegistry::GetUrl('main', '', 'login') . '?'.
        http_build_query(array('backUrl' => '/user/edit/'))
      );
		}
		$this->user = User::GetByRocid($this->LoginUser->RocId, array('Employments.Company'));
		$this->view->MainEdit = $this->getMainEditHtml();
		$this->view->WorkEdit = $this->getWorkEditHtml();
		$this->view->ContactEdit = $this->getContactEditHtml();
		$this->view->AddressEdit = $this->getAddressEditHtml();
		$this->view->PhotoEdit = $this->getPhotoEditHtml();
		$this->view->SettingsEdit = $this->getSettingsEditHtml();

		$this->view->FbRoot = RocidFacebook::GetRootHtml();

		echo $this->view;
	}

	private function getMainEditHtml()
	{
		$view = new View();
		$view->SetTemplate('main');

		$view->Sex = $this->user->Sex;
		$view->FirstName = $this->user->FirstName;
		$view->LastName = $this->user->LastName;
		$view->FatherName = $this->user->FatherName;
                $view->HideFatherName = $this->user->Settings->HideFatherName;
                $view->HideBirthdayYear = $this->user->Settings->HideBirthdayYear;
		$view->Birthday = $this->user->GetParsedBirthday();
                
		return $view;
	}

	private function getWorkEditHtml()
	{
		$view = new View();
		$view->SetTemplate('work');

		$works = $this->user->GetEmployments();
		$size = sizeof($works);
		$workCollection = new ViewContainer();
		for($i = 0; $i < $size; $i++)
		{
			$jobView = new View();
			$jobView->SetTemplate('job');

			/** @var UserEmployment $job */
			$job = $works[$i];

			$jobView->Id = $job->EmploymentId;
			$jobView->CompanyName = $job->Company->Name;
			$jobView->Position = $job->Position;
			$jobView->StartWorking = $job->GetParsedStartWorking();
			$jobView->FinishWorking = $job->GetParsedFinishWorking();
			$jobView->Primary = $job->Primary;
			

			$jobView->LastJob = $i == ($size-1);
			$workCollection->AddView($jobView);
		}

		$view->WorkCollection = $workCollection;

		return $view;
	}

	private function getContactEditHtml()
	{
		$view = new View();
		$view->SetTemplate('contact');
		
		$email = $this->LoginUser->GetEmail();
		if ($email != null)
		{
			$view->EmailId = $email->EmailId;
			$view->Email = $email->Email;
		}
		
		$sites = $this->LoginUser->Sites;
		foreach ($sites as $site)
		{
			$view->Site = trim($view->Site.' http://'.$site->Url);
		}
		$serviceTypes = ContactServiceType::GetAll();
		$contacts = $this->LoginUser->GetServiceAccounts();
		$facebookId = 0;
		$twitterId = 0;
		foreach ($serviceTypes as $type)
		{
			if ($type->Protocol == 'facebook')
			{
				$facebookId = $type->ServiceTypeId;
			}
			if ($type->Protocol == 'twitter')
			{
				$twitterId = $type->ServiceTypeId;
			}
		}

		$connects = $this->LoginUser->Connects;
		foreach ($connects as $connect)
		{
			if ($connect->ServiceTypeId == UserConnect::FacebookId)
			{
				$view->FbConnect = true;
			}
			if ($connect->ServiceTypeId == UserConnect::TwitterId)
			{
				$view->TwiConnect = true;
			}
		}


		$view->FacebookTypeId = $facebookId;
		$view->TwitterTypeId = $twitterId;
		$view->ServiceTypes = $serviceTypes;

		$contactsContainer = new ViewContainer();
		foreach ($contacts as $contact)
		{
			switch ($contact->ServiceTypeId)
			{
				case $facebookId:
					$view->FacebookContactId = $contact->ServiceId;
					$view->FacebookName = $contact->Account;
					break;
				case $twitterId:
					$view->TwitterContactId = $contact->ServiceId;
					$view->TwitterName = $contact->Account;
					break;
				default:
					$contactView = new View();
					$contactView->SetTemplate('messenger');
					$contactView->ContactId = $contact->ServiceId;
					$contactView->Name = $contact->Account;
					$contactView->TypeId = $contact->ServiceTypeId;
					$contactView->ServiceTypes = $serviceTypes;
					$contactsContainer->AddView($contactView);
					break;
			}
		}
		$contactView = new View();
		$contactView->SetTemplate('messenger');
		$contactView->ServiceTypes = $serviceTypes;
		$contactView->Empty = true;
		$contactsContainer->AddView($contactView);
		$view->Contacts = $contactsContainer;

		$phones = $this->LoginUser->GetPhones();
		$phonesContainer = new ViewContainer();
		$flag = true;
		foreach ($phones as $phone)
		{
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

	private function getAddressEditHtml()
	{
		$view = new View();
		$view->SetTemplate('address');

		$address = $this->LoginUser->GetAddress();
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

	private function getPhotoEditHtml()
	{
		$view = new View();
		$view->SetTemplate('photo');

		$view->Photo = $this->LoginUser->GetPhoto();
		$view->MiniPhoto = $this->LoginUser->GetMiniPhoto();

		return $view;
	}

	private function getSettingsEditHtml()
	{
		$view = new View();
		$view->SetTemplate('settings');
		$settings = $this->LoginUser->Settings;
		$view->ProjNews = $settings->ProjNews;
		$view->EventNews = $settings->EventNews;
		$view->NoticePhoto = $settings->NoticePhoto;

    $view->IndexProfile = $settings->IndexProfile == 0 ? 1 : 0;
		return $view;
	}
}

 
