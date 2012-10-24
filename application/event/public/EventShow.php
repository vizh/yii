<?php
AutoLoader::Import('library.social.*');
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('comment.source.*');

class EventShow extends GeneralCommand implements ISettingable
{
  /**
   * Возвращает массив вида:
   * array('name1'=>array('DefaultValue', 'Description'),
   *       'name2'=>array('DefaultValue', 'Description'), ...)
   *  @return array()
   */
  public function GetSettingList()
  {
    return array('UsersOnEventPage' => array(6, 'Количество пользователей выводимых на странице мероприятия'));
  }

  /** @var Event */
  private $event;

  private $url;

  protected function preExecute()
  {
    parent::preExecute();

    $this->view->HeadScript(array('src'=>'/js/libs/jquery.simplemodal.1.4.1.min.js'));
    $this->view->HeadScript(array('src'=>'/js/event.show.js'));
    $this->view->HeadScript(array('src' => '//yandex.st/share/share.js'));
  }

  protected function doExecute($idName = '')
  {
    $this->event = Event::GetEventByIdName($idName, Event::LoadEventAndContacts);

    if (empty($this->event) || $this->event->Visible == Event::EventVisibleN)
    {
      $this->Send404AndExit();
    }

    $titles = Registry::GetWord('titles');
    $this->SetTitle($titles['event'] . ' - ' . $this->event->GetName());

    $this->view->FbRoot = RocidFacebook::GetRootHtml();
    $this->view->Name = $this->event->GetName();

    $this->url = 'http://' . $_SERVER['HTTP_HOST'] . '/events/'. $this->event->IdName . '/';


    // fill meta
    $view = new View();
    $view->SetTemplate('meta');
    $view->Url = $this->url;
    $view->Title = $this->event->GetName();
    $img = $this->event->GetLogo();
    if (strstr($img, 'no_logo'))
    {
      $img = '/images/mlogobig.png';
    }
    $view->Image = 'http://' . $_SERVER['HTTP_HOST'] . $img;
    $view->Quote = $this->event->GetInfo();
    $this->view->MetaTags = $view;


    $this->view->IdName = $this->event->IdName;





    $this->view->Date = $this->GetDateHtml();
    $this->view->FullInfo = $this->GetFullInfoHtml();
    $this->view->Users = $this->GetUsersHtml();
    $this->view->Map = $this->getMapHtml();
    $this->view->ShareButtons = $this->getShareHtml();

    $this->view->Comments = new CommentViewer($this->event->EventId, CommentModel::ObjectEvent);

    echo $this->view;
  }

  /**
   * @return string|null
   */
  private function GetUrlRegistrationHtml()
  {
    return (time() <= strtotime($this->event->DateEnd)) ? $this->event->UrlRegistration : null;
  }

  /**
   * @return int|null
   */
  private function GetFastRegistrationRole()
  {
    return (time() <= strtotime($this->event->DateEnd)) ? $this->event->FastRole : null;
  }

  /**
   * @return int|null
   */
  private function GetFastRegistrationProduct()
  {
    return (time() <= strtotime($this->event->DateEnd)) ? $this->event->FastProduct : null;
  }

  private function GetDateHtml()
  {
    $view = new View();
    $view->SetTemplate('date');

    $start = getdate(strtotime($this->event->DateStart));
    $end = getdate(strtotime($this->event->DateEnd));
    $view->OneMonth = $start['mon'] == $end['mon'];
    $view->OneDay = $start['mday'] == $end['mday'];

    $view->Start = $start;
    $view->End = $end;

    return $view;
  }

  private function GetFullInfoHtml()
  {
    $result = new View();
    $result->SetTemplate('fullinfo');
    $address = $this->event->GetAddress();
    if (!empty($address) 
      && !empty($address->CityId))
    {
      $result->Address = $address;
    }
    $result->Place = $this->event->GetPlace();

    $phones = $this->event->GetPhones();
    if (! empty($phones))
    {
      $phonesContainer = new ViewContainer();
      foreach ($phones as $phone)
      {
        if ($phone->Type != 'fax')
        {
          $view = new View();
          $view->SetTemplate('phone');

          $view->Phone = $phone->Phone;
          $phonesContainer->AddView($view);
        }
      }

      $result->Phones = $phonesContainer;
    }

    $result->Info = $this->event->GetInfo();
    $result->FullInfo = $this->event->GetFullInfo();
    $result->Logo = $this->event->GetLogo();
    $result->Site = $this->event->GetUrl();

    $eventUser = null;
    if ($this->LoginUser !== null)
    {
      $eventUser = $this->event->EventUsers(
        array(
          'condition' => 'EventUsers.UserId = :UserId',
          'params' => array(':UserId' => $this->LoginUser->UserId)
        ));
    }

    $result->UrlRegistration = null;
    if (empty($eventUser) && ($this->GetFastRegistrationRole() != null || $this->GetFastRegistrationProduct() != null))
    {
      $result->UrlRegistration = RouteRegistry::GetUrl('event', '', 'register', array('idName' => $this->event->IdName));
    }
    elseif (empty($eventUser) && !empty($this->event->UrlRegistration))
    {
      $result->UrlRegistration = $this->GetUrlRegistrationHtml();
    }


    return $result;
  }

  private function GetUsersHtml()
  {
    $count = $this->event->GetUsersCount();
    if ($count > 0)
    {
      $result = new View();
      $result->SetTemplate('usercontainer');

      $usersOnPage = SettingManager::GetSetting('UsersOnEventPage');
      $users = $this->event->GetRandomUsers($usersOnPage, $count);
      $container = new ViewContainer();
      foreach ($users as $user)
      {
        $view = new View();
        $view->SetTemplate('user');

        $view->RocId = $user->GetRocId();
        $view->Photo = $user->GetMiniPhoto();
        $view->FirstName = $user->FirstName;
        $view->LastName = $user->LastName;
        $view->FatherName = $user->FatherName;

        $container->AddView($view);
      }
      $result->Count = $count;
      $result->Users = $container;
      $result->IdName = $this->event->IdName;

      return $result;
    }

    return '';
  }

  private function getShareHtml()
  {
    $view = new View();
    $view->SetTemplate('share');

    $view->Name = $this->event->GetName();
    $view->GoogleDateStart = date('Ymd', strtotime($this->event->DateStart));
    $view->GoogleDateEnd = date('Ymd', strtotime($this->event->DateEnd)+24*60*60);
    $view->SiteHost = $_SERVER['HTTP_HOST'];
    $titles = Registry::GetWord('titles');
    $view->SiteName = $titles['general'];
    $view->Info = $this->event->GetInfo();
    $view->DateStart = $this->event->DateStart;
    $view->DateEnd = $this->event->DateEnd;
    $view->LogoImage = $this->event->GetLogo();
    $view->IdName = $this->event->IdName;
    $view->Place = $this->event->Place;

    $view->Url = $this->url;


    return $view;
  }

  private function getMapHtml()
  {
    $result = '';
    if ( !empty($this->event->Place))
    {
      $result = new View();
      $result->SetTemplate('map');
      $result->Name = $this->event->Name;
      $address = $this->event->GetAddress();
      if ($address !== null 
        && !empty($address->CityId))
      {
        $result->Address = $address;
      }
      else
      {
        $result->Address = $this->event->Place;
      }
    }
    return $result;
  }
}
