<?php
AutoLoader::Import('library.rocid.company.*');
AutoLoader::Import('library.rocid.activity.*');
AutoLoader::Import('news.source.*');

class CompanyShow extends GeneralCommand
{

	protected function preExecute()
	{
		parent::preExecute();
		//Установка хеадера
		$this->view->HeadLink(array('href'=>'/css/company.css', 'rel'=>'stylesheet', 'type'=>'text/css'));

		$titles = Registry::GetWord('titles');
		$this->SetTitle($titles['general']);
	}

	/**
	 * @var Company
	 */
	private $company;

	protected function doExecute($companyId = '')
	{
		$companyId = intval($companyId);
    $this->company = Company::GetById($companyId);//, Company::LoadMiddleInfo);
		if (empty($this->company))
		{
			$this->Send404AndExit();
		}

		$company = array();
		
		$company['CompanyId'] = $this->company->GetCompanyId();
		$company['Name'] = $this->company->GetName();
		$company['FullName'] = $this->company->GetFullName();
		
		$this->view->Url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

		$this->view->Logo = $this->company->GetLogo();
		$this->view->Info = $this->getInfoHtml();
		$this->view->Email = $this->getEmailHtml();
		$this->view->Site = $this->getSiteHtml();
		$this->view->Skype = $this->getSkypeHtml();
		$this->view->Phones = $this->getPhonesHtml();
		$this->view->Address = $this->getAddressHtml();
		$this->view->Users = $this->getUsersHtml();
		
		$this->view->Company = $company;

		if ($this->LoginUser != null)
		{
			$this->view->Auth = true;
			$this->view->ShowEdit = $this->LoginUser->IsHaveAdminPermissions();

      $this->view->ShowEdit = $this->company->IsEditor($this->LoginUser) || $this->view->ShowEdit;

			$interest = UserInterestCompany::GetUserInterestCompany($this->LoginUser->UserId, $this->company->CompanyId);
			if ($interest != null)
			{
				$this->view->InterestCompany = true;
			}
		}
		
	    // fill meta
	    $view = new View();
	    $view->SetTemplate('meta');
	    $view->Url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	    $view->Title = $company['Name'];
	    $view->Image = 'http://' . $_SERVER['HTTP_HOST'] . $this->view->Logo;
	    $this->view->MetaTags = $view;
		
		echo $this->view;
	}
	
	private function getInfoHtml()
	{
		$view = new View();
		$view->SetTemplate('info');
		$info = $this->company->GetInfo();
		$view->Info = $info;
		$view->CompanyId = $this->company->CompanyId;

		$news = NewsPost::GetLastByCompany(1, 1, $this->company->CompanyId, array(),
																					 null, NewsPost::StatusDeleted);
		$view->HasRss = ! empty($news);
		return $view;
	}
	
	private function getEmailHtml()
	{
		$emails = $this->company->GetEmails();
		if (! empty($emails))
		{
			$view = new View();
			$view->SetTemplate('email');
			$view->Emails = $emails;
			$view->Size = sizeof($emails);
			return $view;
		}
		
		return '';
	}
	
	private function getSiteHtml()
	{
		$sites = $this->company->GetSites();
		if (! empty($sites))
		{
			$view = new View();
			$view->SetTemplate('site');
			$view->Sites = $sites;
			$view->Size = sizeof($sites);
			return $view;
		}
		
		return '';
	}
	
	private function getSkypeHtml()
	{
		$contacts = $this->company->GetServiceAccounts();
		if (! empty($contacts))
		{
			foreach ($contacts as $contact)
			{
				if ($contact->ServiceType->Protocol == 'skype')
				{
					$view = new View();
					$view->SetTemplate('contact');
					$view->Contact = array($contact->Account);
					$view->Size = 1;
					$view->ContactName = 'Skype';
					return $view;
				}
			}
		}
		
		return '';
	}
	
	private function getPhonesHtml()
	{
		$phones = $this->company->GetPhones();
		if (! empty($phones))
		{
			$phoneNumbers = array();
			$faxNumbers = array();
			foreach ($phones as $phone)
			{
				if ($phone->Type == 'fax')
				{
					$faxNumbers[] = $phone->Phone;
				}
				else
				{
					$phoneNumbers[] = $phone->Phone;
				}
			}
			
			$result = new ViewContainer();
			
			if (! empty($phoneNumbers))
			{
				$view = new View();
				$view->SetTemplate('contact');
				$view->Contact = $phoneNumbers;
				$view->Size = sizeof($phoneNumbers);
				$view->ContactName = 'Телефон';
				$result->AddView($view);
			}
			
			if (! empty($faxNumbers))
			{
				$view = new View();
				$view->SetTemplate('contact');
				$view->Contact = $faxNumbers;
				$view->Size = sizeof($faxNumbers);
				$view->ContactName = 'Факс';
				$result->AddView($view);
			}
			
			return $result;
		}
		
		return '';
	}
	
	private function getAddressHtml()
	{
		global $Words;
		
		$address = $this->company->GetAddress();
		if ($address != null)
		{
			$this->view->HeadScript(array('src'=>'http://api-maps.yandex.ru/1.1/index.xml?key=AALEwk0BAAAAEa_5EwIAvRMrqS5OTlCVonGim9-DFyUmyYYAAAAAAAAAAADcDy3TT0owKhCZ7GexLgGYR8E94g=='));
			$this->view->HeadScript(array('src'=>'/js/company.js'));
			
			$view = new View();
			$view->SetTemplate('address');
			$addrStack = false;
			
			if ($address->City != null)
			{
				$addrStack[] = $view->City = $address->City->Name;
			}
			else
			{
				$view->City = false;
			}
			if (!empty($address->Street) && !empty($address->House))
			{
				$addrStack[] = $view->Street = $address->Street;
				
				$view->House = preg_split('/-/', trim($address->House), -1);
				$view->OldAddres = false;

				if (!empty($view->House[0]))
				{
					$addrStack[] = $Words['address']['house'][0] . ' ' . $view->House[0];
				}
				if (!empty($view->House[1]))
				{
					$addrStack[] = $Words['address']['house'][1] . ' ' . $view->House[1];
				}
				if (!empty($view->House[2]))
				{
					$addrStack[] = $Words['address']['house'][2] . ' ' . $view->House[2];
				}
			}
			else if (! empty($address->OldAddress))
			{
				$addrStack[] = $view->OldAddress = $address->OldAddress;
			}
			else
			{
				$view->Street = false;
				$view->OldAddress = false;
			}
			
			if ($addrStack && count($addrStack) > 0) {
				if ($view->Street || $view->OldAddress) {
					foreach($addrStack as $key => $value) $addrStack[$key] = trim($value);
					$view->address = implode(', ', $addrStack);
					$view->encodeAddress = urlencode($view->address);
				}
			}
			else {
				$view->address = $addrStack;
			}

			return $view;
		}    
		return '';
	}
	
	private function getUsersHtml()
	{
		$users = $this->company->GetUsersAll();

		if (!empty($users))
		{
      
      // Убирает дубликаты и добавляет в работу последнюю добавленную
      $usersUnq = array();
      foreach ($users as $user)
      {
        if (isset($usersUnq[$user->UserId])
          && $user->EmploymentId < $usersUnq[$user->UserId]->EmploymentId)
        {
          continue;
        }
        $usersUnq[$user->UserId] = $user;
      }
      
			$result = new View();
			$result->SetTemplate('usercontainer');

			$containerCurrentUsers = new ViewContainer();
			$containerOldUsers = new ViewContainer();

			$flagCurrentUsers = false;
			$flagOldUsers = false;
			foreach ($usersUnq as $user)
			{
				$view = new View();
				$view->SetTemplate('user');
				
				$view->RocId = $user->User->GetRocId();
				$view->LastName = $user->User->GetLastName();
				$view->FirstName = $user->User->GetFirstName();
				$view->FatherName = $user->User->GetFatherName();
				$view->Position = $user->Position;
				$view->Photo = $user->User->GetMiniPhoto();

				$finish = $user->GetParsedFinishWorking();
				// Работающие в данной компании
				if ($finish['year'] > date('Y'))
				{
					$containerCurrentUsers->AddView($view);
					if ($flagCurrentUsers)
					{
						$empty = new View();
						$empty->SetTemplate('user');
						$empty->Empty = true;
						$containerCurrentUsers->AddView($empty);
						$flagCurrentUsers = false;
					}
					else
					{
						$flagCurrentUsers = true;
					}
				}
				// Бывшие сотрудники компании
				else {
					$containerOldUsers->AddView($view);
					if ($flagOldUsers)
					{
						$empty = new View();
						$empty->SetTemplate('user');
						$empty->Empty = true;
						$containerOldUsers->AddView($empty);
						$flagOldUsers = false;
					}
					else
					{
						$flagOldUsers = true;
					}
				}
			}

			$result->Users = $containerCurrentUsers;
			$result->UsersOld = $containerOldUsers;
			
			return $result;
		}
		
		return '';
	}
	
	
//***************************  
// OLD VERSION
//***************************

	/**
	* @param array[CompanyUser] $companyUsers
	*/
	private function fillUsers($employments)
	{
		
		$containerNow = new ViewContainer();
		$containerBefore = new ViewContainer();

		foreach ($employments as $employment) 
		{
			
			// -------------------------
			//print '<hr>Пользователь: '. $employment->User->GetRocId() .'<br />';

			$events = $employment->User->GetEventUsers();
			foreach ($events as $event) {
				$eventData = $event->GetEvent();
				//foreach ($eventData as $anyData) print $anyData .'<br />';
			}
			// -------------------------
			
			//clearstatcache();
			$view = new View();
			$view->SetTemplate('staff_item');
			
			$view->RocId = $employment->User->GetRocId();
			$view->LastName = $employment->User->GetLastName();
			$view->FirstName = $employment->User->GetFirstName();
			$view->FatherName = $employment->User->GetFatherName();
			$view->Position = $employment->Position;

//      print $employment->GetEvent()->Name;

			// Фотография пользователя
			$img = '/files/photo/' . $view->RocId . '_50.jpg';
			$view->Photo = (file_exists($_SERVER["DOCUMENT_ROOT"] . $img)) ? $img : '/files/photo/no_photo_50.png';

			$containerName = ($employment->FinishWorking > date('Y')) ? 'containerNow' : 'containerBefore';
			${$containerName}->AddView($view);
		}
		
		$view = new View();
		$templateName = (!$containerBefore->IsEmpty()) ? 'staff_full' : 'staff_now';
		$view->SetTemplate($templateName);
		$view->Now = (!$containerNow->IsEmpty()) ? $containerNow : '<div align="left" style="margin-top: 20px; padding-left: 10px; color: #969696;">Сотрудники не найдены.</div>';
		$view->Before = $containerBefore;
		
		return $view;

	}
	
	// Заполнение телефонами
	private function fillPhones($phones)
	{
		$container = new ViewContainer();

		$items = array();
		foreach($phones as $phone)
		{
			if ($phone->Type == 'fax' && trim($phone->Phone) != '') $items['fax'][] = $phone->Phone;
			else {
				if (trim($phone->Phone) != '') $items['phone'][] = $phone->Phone;
			}
		}

		
		$types = array('phone', 'fax');
		
		foreach ($types as $type) {
			if (isset($items[$type]) && count($items[$type]) > 0) {
				$view = new View();
				$view->SetTemplate($type);
				$view->{ucfirst($type)} = implode(', ', $items[$type]);
				$container->AddView($view);
			}

		}
		return $container;
	}  

	// Заполнение E-Mail'ами
	private function fillEmails($emails)
	{
		$items = array();
		$view = '';
		foreach($emails as $email)
		{
			if (trim($email->Email) != '') $items['email'][] = '<a href="mailto:'. $email->Email .'">'. $email->Email .'</a>';
		}

		if (isset($items['email']) && count($items['email']) > 0) 
		{
			$view = new View();
			$view->SetTemplate('email');
			$view->Emails = implode(', ', $items['email']);
		}
		return $view;
	}

	// Заполнение адресов
	private function fillAddress($address)
	{
		$items = array();     
		$view = '';
		
		return '';
				
		$items['postalIndex'] = $address->PostalIndex;
		$city = $address->GetCity()->GetCityName();
		$items['city'] = ($city) ? 'г. ' . $city : '';

		if ($address->Street == '' && $address->House == '' && $address->Apartment == '') {
			$items['oldAddress'] = $address->OldAddress;
		}
		else {
			$items['street'] = $address->Street;
			@list($house, $building, $construction) = explode('-', $address->House);
			$items['house'] = ($house != '') ? 'д.'. $house : '';
			$items['building'] = ($building != '') ? 'стр.'. $building : '';
			$items['construction'] = ($construction != '') ? 'корп.'. $construction : '';

			$apartment = $address->Apartment;
			$items['apartment'] = ($apartment) ? 'кв./оф./комн.'. $apartment : '';
		}

		$addressPart = array_diff($items, array(''));

		if (isset($addressPart) && count($addressPart) > 0) {
			$view = new View();
			$view->SetTemplate('address');
			$view->Address = implode(', ', $addressPart);
		}

		return $view;

	}

	/**
	* @param array[EventUser] $eventUsers
	*/
	private function fillEvents($eventUsers)
	{    
		//print_r($eventUsers);
/*
		$container = new ViewContainer();
		foreach ($eventUsers as $value) 
		{
			$view = new View();
			$view->SetTemplate('events');
			
			$event = $value->GetEvent();
			$view->EventName = $event->Name;
			$view->Role = $value->RoleId;
			
			$container->AddView($view);
		}
		if ($container->IsEmpty())
		{
			$container = 'Информация об участии пользователя в профессиональных мероприятиях отсутствует.';
		}    
		return $container;
*/
	 
	}

}
