<?php
AutoLoader::Import('library.rocid.settings.*');
AutoLoader::Import('library.rocid.activity.*');
AutoLoader::Import('library.social.*');
AutoLoader::Import('library.widgets.userbar.*');
AutoLoader::Import('main.source.*');
AutoLoader::Import('news.source.*');

class MainIndex extends GeneralCommand implements ISettingable
{
/**
* ISettingable Members
*/
	public function GetSettingList()
	{
		return array(
			'LastTapeNews' => array(6, 'Количество новостей в ленте новостей'),
			'LastNews' => array(4, 'Количество последних новостей, которые выводятся в списке'),
			'LastCompanyNews' => array(5, 'Количество последних новостей компаний, которые выводятся в списке'),
		);
	}
	
	protected function preExecute()
	{
		parent::preExecute();

		$this->view->HeadScript(array('src'=>'/js/libs/jquery.jcarousel.min.js'));
		$this->view->HeadScript(array('src'=>'/js/jquery.jcarousel.js'));
		
		$titles = Registry::GetWord('titles'); 
		$this->SetTitle($titles['general']);

    $this->view->HeadLink(array('rel' => 'alternate', 'type' => 'application/rss+xml',
                               'title' => $titles['news'], 'href' => RouteRegistry::GetUrl('news', '', 'rss')));

    $this->view->HeadLink(array('rel' => 'alternate', 'type' => 'application/rss+xml',
                               'title' => $titles['news'] . $titles['rss_companies'],
                               'href' => RouteRegistry::GetUrl('news', '', 'rss', array('company' => 'company'))));
	}
	
	protected function doExecute()
	{
		if ($this->LoginUser === null)
		{
			$this->view->HeadScript(array('src'=>'/js/login.js'));
      $this->view->HeadScript(array('src'=>'/js/social.js'));
      $this->view->HeadScript(array('src'=>'/js/libs/jquery.simplemodal.1.4.1.min.js'));
			$this->fillNonAuthTemplate();
		}
		else
		{
			$this->fillAuthTemplate();
		}     
		echo $this->view->__toString();
	}
	
	protected function fillNonAuthTemplate()
	{
		$this->view->SetTemplate('nonauth');
		$authform = new AuthUserForm();
		if ($authform->IsRequest())
		{
			if ($authform->Validate())
			{
        $identity = null;
        $validator = new CEmailValidator();
        if ($validator->validateValue($authform->GetRocidOrEmail()))
        {
          $identity = new EmailIdentity($authform->GetRocidOrEmail(), $authform->GetPassword());
        }
        else
        {
          $identity = new RocidIdentity($authform->GetRocidOrEmail(), $authform->GetPassword());
        }
        $identity->authenticate();
				if ($identity->errorCode == CUserIdentity::ERROR_NONE)
				{
          if ($authform->NotRemember())
          {
            Yii::app()->user->login($identity);
          }
          else
          {
            Yii::app()->user->login($identity, $identity->GetExpire());
          }
					Lib::Redirect('/');
				}
				else
				{
					$this->AddErrorNotice('Неправильная пара Email / rocID - пароль!', 'Авторизоваться не удалось');
				}
			}
			else
			{
				$errors = $authform->GetErrors('rocid_or_mail');
				if (in_array('NotEmpty', $errors))
				{
					$this->AddErrorNotice('Поле Email / rocID не может быть пустым');
				}
				
				$errors = $authform->GetErrors('password');
				if (in_array('NotEmpty', $errors))
				{
					$this->AddErrorNotice('Поле пароль не может быть пустым');
				}
			}
		}
		
		$this->view->ActiveForm = 'auth';
		
		$regform = new RegistrationForm();
		if ($regform->IsRequest())
		{
			if ($regform->Validate())
			{
				$user = User::Register($regform->GetEmail(), $regform->GetPassword());
				if ($user != null)
				{
          $user->LastName = $regform->GetLastName();
          $user->FirstName = $regform->GetFirstName();
          $user->save();
          $identity = new RocidIdentity($user->GetRocId(), $regform->GetPassword());
          $identity->authenticate();
          if ($identity->errorCode == CUserIdentity::ERROR_NONE)
          {
            Yii::app()->user->login($identity, $identity->GetExpire());
          }
					Lib::Redirect('/');
				}
				else
				{
					$this->AddErrorNotice('Учётная запись с введённым вами email уже зарегистрирована.', 'Вероятнее всего вы уже регистрировались на сайте — попробуйте восстановить пароль.');
				}
			}
			else
			{
        $errors = $regform->GetErrors('lastname');
        if (in_array('NotEmpty', $errors))
				{
					$this->AddErrorNotice('Поле Фамилия не может быть пустым');
				}

        $errors = $regform->GetErrors('firstname');
        if (in_array('NotEmpty', $errors))
				{
					$this->AddErrorNotice('Поле Имя не может быть пустым');
				}

				$errors = $regform->GetErrors('email');
				if (in_array('NotEmpty', $errors))
				{
					$this->AddErrorNotice('Поле Email не может быть пустым');
				}
				if (in_array('Email', $errors))
				{
					$this->AddErrorNotice('Введенное значение поля Email некорректно');
				}
				
				$errors = $regform->GetErrors('password');
				if (in_array('NotEmpty', $errors))
				{
					$this->AddErrorNotice('Поле пароль не может быть пустым');
				}
			}
			$this->view->ActiveForm = 'reg';
		}

    $this->parseErrors();

		$this->view->FbRoot = RocidFacebook::GetRootHtml();

		$this->view->AuthForm = $authform;
		$this->view->RegForm = $regform;
		$this->view->ErrorAuth = isset($this->ErrorAuth) ? $this->ErrorAuth : false;
		$this->view->NewsTape = $this->getNewsTapeHtml(true);
		$this->view->PromoTop = $this->getPromoTopHtml();
    $this->view->AllNews = $this->getNewsHtml();
	}

  private function parseErrors()
  {
    $error = Registry::GetRequestVar('error');

    switch ($error)
    {
      case 'email_reg_fail':
        $this->AddErrorNotice('Учётная запись с введённым вами email уже зарегистрирована.', 'Вероятнее всего вы уже регистрировались на сайте — попробуйте восстановить пароль.');
        break;
      case 'fb_connect_reg_fail':
        $this->AddErrorNotice('Сервис Facebook не доступен!', 'Не удалось получить данные аккаунта.');
        break;
      case 'twi_connect_reg_fail':
        $this->AddErrorNotice('Сервис Twitter не доступен!', 'Не удалось получить данные аккаунта.');
        break;
    }
  }
	
	protected function fillAuthTemplate()
	{
		$this->view->SetTemplate('auth');

		$this->view->HeadScript(array('src'=>'/js/user.ind.js'));

		$this->view->MyCalendar = $this->getMyCalendarHtml();
		$this->view->Profile = $this->getProfileHtml();
		$this->view->NewsTape = $this->getNewsTapeHtml();
		$this->view->AllNews = $this->getNewsHtml();

		$this->view->Activity = ActivityOutput::GetHtml($this->LoginUser->UserId, 20,
																										array(ActivityOutput::TypeUser));
	}

	private function getMyCalendarHtml()
	{
		$view = new View();
		$view->SetTemplate('mycalendar');

		$events = Event::GetFutureEventsFromDate(date('Y-m-d'), 4);// GetFutureEvents(4);
		$i = 0;
		$eventContainer = new ViewContainer();
		foreach ($events as $event)
		{
			$i++;
			$viewEvent = new View();
			$viewEvent->SetTemplate('mycalendarevent');

			$viewEvent->IdName = $event->IdName;
			$viewEvent->DateStart = getdate(strtotime($event->DateStart));
			$viewEvent->DateEnd = getdate(strtotime($event->DateEnd));
			$viewEvent->Name = $event->GetName();
			$viewEvent->Url = $event->Url;
			$viewEvent->UrlRegistration = $event->UrlRegistration;
			if ($i == sizeof($events))
			{
				$viewEvent->Last = true;
			}

			$eventContainer->AddView($viewEvent);
		}

		$view->Events = $eventContainer;

		return $view;
	}

	private function getProfileHtml()
	{
		$view = new View();
		$view->SetTemplate('profile');

		$view->RocID = $this->LoginUser->GetRocId();
		$view->FullName = $this->LoginUser->GetFullName();
		$view->MediumPhoto = $this->LoginUser->GetMediumPhoto();
		
		$employment = $this->LoginUser->EmploymentPrimary();
		if (! empty($employment))
		{
			$view->LastPosition = $employment->Position;
			$view->LastCompany = !empty($employment->Company) ? $employment->Company->Opf . ' &laquo;' . $employment->Company->Name . '&raquo;' : '';
		}
		
		$email = $this->LoginUser->GetEmail();
		if (! empty($email))
		{
			$view->Email = $email->Email;
		}

		$phones = $this->LoginUser->GetPhones();
		if (! empty($phones))
		{
			$phoneResult = null;
			foreach ($phones as $phone)
			{
				if ($phone->Type == 'mobile')
				{
					$phoneResult = $phone;
					break;
				}
				if ($phone->Type == 'work')
				{
					$phoneResult = $phone;
				}
			}
			if ($phoneResult != null)
			{
				$view->Phone = $phone->Phone;
			}
		}

		return $view;    
	}

	private function getNewsHtml()
	{
		$view = new View();
		$view->SetTemplate('allnews');

    $lastNews = NewsPost::GetLastByCompany(SettingManager::GetSetting('LastNews'), 1, null);
		$lastNewsContainer = new ViewContainer();
		foreach ($lastNews as $news)
		{
			$newsView = new View();
			$newsView->SetTemplate('textnews');

			$newsView->Link = $news->GetLink();
			$newsView->Date = date('d.m.Y H:i',strtotime($news->PostDate));
			$newsView->Title = $news->Title;
			$newsView->Quote = $news->Quote;

			$lastNewsContainer->AddView($newsView);
		}

    $companyNews = NewsPost::GetLastByCompany(SettingManager::GetSetting('LastCompanyNews'), 1, 0);
		$companyNewsContainer = new ViewContainer();
		foreach ($companyNews as $news)
		{
			$newsView = new View();
			$newsView->SetTemplate('textnews');

			$newsView->Link = $news->GetLink();
			$newsView->Date = date('d.m.Y H:i',strtotime($news->PostDate));
			$newsView->Title = $news->Title;
			$newsView->Quote = $news->Quote;

			$companyNewsContainer->AddView($newsView);
		}


		$view->LastNews = $lastNewsContainer;
		$view->CompanyNews = $companyNewsContainer;

//		$viewAds = new View();
//		$viewAds->SetTemplate('swf', 'core', 'banner', '', 'public');
//		$view->Banner = $viewAds;

    $view->Banner = $this->getBanner();

		return $view;
	}

	private function getNewsTapeHtml($showHeader = false)
	{
		$view = new View();
		$view->SetTemplate('promotape');

		$count = SettingManager::GetSetting('LastTapeNews');
		$promolist = NewsPromo::GetTape($count, 0);
		$promoContainer = new ViewContainer();
		foreach ($promolist as $promo)
		{
			$promoView = new View();
			$promoView->SetTemplate('promo');

			$promoView->Link = $promo->Link;
			$promoView->TitleTop = $promo->TitleTop;
			$promoView->Title = $promo->Title;
			$promoView->Description = $promo->Description;
			$promoView->Image = $promo->GetImage();

			$promoContainer->AddView($promoView);
		}

		$view->PromoList = $promoContainer;
		$view->ShowHeader = $showHeader;

		return $view;
	}

	private function getPromoTopHtml()
	{
		$result = '';

		$count = SettingManager::GetSetting('LastTapeNews');
		$promolist = NewsPromo::GetTape($count, 1);

		foreach ($promolist as $promo)
		{
			$promoView = new View();
			$promoView->SetTemplate('promotop');

			$promoView->Link = $promo->Link;
			$promoView->TitleTop = $promo->TitleTop;
			$promoView->Image = $promo->GetImageBig();

			$result .= $promoView;
		}

		return $result;
	}	

	
	protected function getActivityTape()
	{
		$activityTape = new ActivityTape($this->LoginUser);
		$activityTape->FillTape();
		$items = $activityTape->GetTape();
		$viewContainer = new ViewContainer();
		foreach ($items as $item)
		{
			$viewContainer->AddView($item->GetView());
		}
		return $viewContainer;
	}
}