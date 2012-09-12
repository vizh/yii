<?php
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.activity.*');
AutoLoader::Import('comission.source.*');

class UserShow extends GeneralCommand
{

  protected function preExecute()
  {
    parent::preExecute();
    //Установка хеадера
    //$this->view->HeadLink(array('href'=>'/css/blog.css', 'rel'=>'stylesheet','type'=>'text/css'));
    $this->view->HeadScript(array('src'=>'/js/user.show.js'));

    $titles = Registry::GetWord('titles');
    $this->SetTitle($titles['general']);
  }

  /**
   * @var User
   */
  private $user;

  /**
   * @var boolean
   */
  private $self = false;

  protected function doExecute($rocId = '')
  {
    if ($this->LoginUser != null && $this->LoginUser->GetRocId() == $rocId)
    {
      $this->self = true;
    }
    //Timer::ShowTimeStamp('start do command');
    $rocId = intval($rocId);
    if ($rocId === 0)
    {
      $this->Send404AndExit();
    }
    $this->user = User::GetByRocid($rocId);/*, array('Addresses.City.Country', 'Phones',
			'ServiceAccounts', 'Sites', 'EventUsers.EventRole', 'EventUsers.Event', 
			'Activities', 'Employments.Company')); */
    //Заполнение View данными
    //Timer::ShowTimeStamp('load user');
    if ($this->user == null || $this->user->Settings->Visible == 0 || $this->user->Settings->Agreement == 0)
    {
      $this->Send404AndExit();
    }

    if ($this->user->Settings->IndexProfile == 0)
    {
      $this->view->HeadMeta(array('name' => 'robots', 'content' => 'noindex'));
    }

    $titles = Registry::GetWord('titles');
    $this->SetTitle($titles['plain'] . ' ' . $this->user->GetLastName() . ' ' . $this->user->GetFirstName());

    //Заполняем личные данные
    $this->view->User = $this->user;
    $this->view->Address = $this->getAddressHtml();
    $this->view->Age = $this->getAgeHtml();
    $this->view->Email = $this->getEmailHtml();
    $this->view->Site = $this->GetSiteHtml();
    $this->view->ServiceAccount = $this->getServiceAccountHtml();

    $this->view->Work = $this->getWorkHtml();
    $this->view->Event = $this->getEventHtml();
    $this->view->Commission = $this->getCommissionHtml();
    //$this->view->Activity = $this->getActivityHtml();

    $this->view->Self = $this->self;
    if ($this->LoginUser != null)
    {
      $this->view->Auth = true;
      $interest = UserInterestPerson::GetUserInterestPerson($this->LoginUser->UserId, $this->user->UserId);
      if ($interest != null)
      {
        $this->view->InterestPerson = true;
      }
    }
    $this->view->RocId = $rocId;

    echo $this->view;
    //Timer::ShowTimeStamp('End output result');
  }

  private function getAddressHtml()
  {
    $address = $this->user->GetAddress();
    if (! empty($address) && ! empty($address->City))
    {
      $view = new View();
      $view->SetTemplate('address');
      $view->City = $address->City->Name;
      $view->Country = $address->City->Country->Name;

      return $view;
    }

    return '';
  }


  private function getAgeHtml()
  {
    $birthday = $this->user->GetParsedBirthday();
    $view = new View();
    $view->SetTemplate('age');
    if (empty($birthday) || empty($birthday['year']))
    {
      $view->Empty = true;
    }
    else if (empty($birthday['month']))
    {
      $view->OnlyYear = true;
      $view->Year = $birthday['year'];
    }
    else if (empty($birthday['day']))
    {
      $view->WithMonth = true;
      $view->Year = $birthday['year'];
      $view->Month = $birthday['month'];
    }
    else
    {
      $view->Full = true;
      $view->Year = $birthday['year'];
      $view->Month = $birthday['month'];
      $view->Day = $birthday['day'];
    }
    $view->HideBirthdayYear = $this->user->Settings->HideBirthdayYear;
    $view->Sex = $this->user->Sex;

    return $view;
  }

  private function getEmailHtml()
  {
    $email = $this->user->GetEmail();
    if (! empty($email))
    {
      $view = new View();
      $view->SetTemplate('email');

      $view->Email = $email->Email;

      return $view;
    }

    return '';
  }

  private function GetSiteHtml()
  {
    //$site = $this->user->GetSite();
    if (! empty($this->user->Sites))
    {
      $view = new View();
      $view->SetTemplate('site');
      $view->Size = sizeof($this->user->Sites);
      $view->Sites = $this->user->Sites;

      return $view;
    }

    return '';
  }

  private function getServiceAccountHtml()
  {
    $contacts = $this->user->GetServiceAccounts();
    if (! empty($contacts))
    {
      $result = new ViewContainer();
      $facebook = array();
      $skype = array();
      $icq = array();
      $moikrug = array();
      $twitter = array();
      foreach ($contacts as $contact)
      {
        if (! empty($contact->ServiceType) && ! empty($contact->Account))
        {
          switch ($contact->ServiceType->Protocol)
          {
            case 'facebook':
              $contact->Account = trim($contact->Account,'/ ');
              $contact->Account = substr($contact->Account, strrpos($contact->Account, '/')+1);
              $facebook[] = $contact->Account;
              break;
            case 'skype':
              $skype[] = $contact->Account;
              break;
            case 'icq':
              $icq[] = $contact->Account;
              break;
            case 'moikrug':
              $moikrug[] = $contact->Account;
              break;
            case 'twitter':
              $contact->Account = trim($contact->Account,'/ ');
              $contact->Account = substr($contact->Account, strrpos($contact->Account, '/')+1);
              $twitter[] = $contact->Account;
              break;
          }
        }
      }

      if (! empty($facebook))
      {
        $view = new View();
        $view->SetTemplate('serviceaccount');
        $view->Size = sizeof($facebook);
        $view->ContactName = 'Facebook';
        $view->Class = 'i-facebook';
        $view->Contact = $facebook;
        $view->Link = (is_numeric($facebook)) ? "http://facebook.com/profile.php?id=##" : "http://facebook.com/##";

        $result->AddView($view);
      }

      if (! empty($skype))
      {
        $view = new View();
        $view->SetTemplate('serviceaccount');
        $view->Size = sizeof($skype);
        $view->ContactName = 'Skype';
        $view->Class = 'i-skype';
        $view->Contact = $skype;
        $view->Link = '';

        $result->AddView($view);
      }

      if (! empty($icq))
      {
        $view = new View();
        $view->SetTemplate('serviceaccount');
        $view->Size = sizeof($icq);
        $view->ContactName = 'icq';
        $view->Class = 'i-icq';
        $view->Contact = $icq;
        $view->Link = "http://www.icq.com/people/about_me.php?uin=##";

        $result->AddView($view);
      }

      if (! empty($moikrug))
      {
        $view = new View();
        $view->SetTemplate('serviceaccount');
        $view->Size = sizeof($moikrug);
        $view->ContactName = 'Мой круг';
        $view->Class = 'i-mycircle';
        $view->Contact = $moikrug;
        $view->Link = "http://##.moikrug.ru";

        $result->AddView($view);
      }

      if (! empty($twitter))
      {
        $view = new View();
        $view->SetTemplate('serviceaccount');
        $view->Size = sizeof($twitter);
        $view->ContactName = 'Twitter';
        $view->Class = 'i-twitter';
        $view->Contact = $twitter;
        $view->Link = "http://twitter.com/##";

        $result->AddView($view);
      }

      return $result;
    }


    return '';
  }
  
  private function getCommissionHtml ()
  {
    $criteria = new CDbCriteria();
    $criteria->condition = 't.UserId = :UserId AND t.ExitTime IS NULL';
    $criteria->params[':UserId'] = $this->user->UserId;
    $criteria->with = array('Role', 'Commission');
    $commissions = ComissionUser::model()->findAll($criteria);
    if (!empty ($commissions))
    {
      $result = new View();
      $result->SetTemplate('commissioncontainer');
      
      $containerVisibleCommission = new ViewContainer();
      $containerInvisibleCommission = new ViewContainer();
      
      $countView = 0;
      foreach ($commissions as $commission)
      {
        $countView++;
        $view = new View();
        $view->SetTemplate('commission');
        $view->Role = $commission->Role;
        $view->Commission = $commission->Commission;
        if ($countView < 4)
        {
          $containerVisibleCommission->AddView($view);
        }
        else 
        {
          $containerInvisibleCommission->AddView($view);
        }
      }
      $result->CommissionVisible = $containerVisibleCommission;
      $result->CommissionInvisible = $containerInvisibleCommission;
      return $result;
    }
  }
  
  private function getWorkHtml()
  {
    $employments = $this->user->GetEmployments();
    if (! empty($employments))
    {
      $result = new View();
      $result->SetTemplate('workcontainer');

      $containerVisibleWork   = new ViewContainer();
      $containerInvisibleWork = new ViewContainer();

      $countView = 0;
      foreach ($employments as $employment)
      {
        $countView++;
        $company = $employment->GetCompany();

        $view = new View();
        $view->SetTemplate('work');

        if (! empty($company))
        {
          if ($employment->Primary == 1)
          {
            $this->view->CurrentWork = $company->FullName;
          }
          $view->Id = $company->CompanyId;
          $view->Name = $company->Name;
          $view->FullName = $company->FullName;
        }
        else
        {
          Lib::log('Message: Empty Company, but no empty employment.  Trace string: getUsersHtml in application/user/UserList.php ', CLogger::LEVEL_ERROR, 'application');
        }

        $view->Position = $employment->Position;

        $view->StartWorking  = $employment->GetFormatedStartWorking();
        $view->FinishWorking = $employment->GetFormatedFinishWorking();

        if ($countView > 3) {
          $containerInvisibleWork->AddView($view);
        }
        else {
          $containerVisibleWork->AddView($view);
        }
      }

      $result->WorkVisible = $containerVisibleWork;
      $result->WorkInvisible = $containerInvisibleWork;

      return $result;
    }

    return '';
  }

  private $countEventView;
  private function getEventHtml()
  {
    $eventUsers = $this->user->EventUsers(array('with' => array('Event', 'EventRole', 'Day')));
    $eventUsersByEventId = $this->transformEventUsersByEventId($eventUsers);
    if (! empty($eventUsersByEventId))
    {
      $result = new View();
      $result->SetTemplate('eventcontainer');

      $visibleEventViews = new ViewContainer();
      $invisibleEventViews = new ViewContainer();

      /** @var $allEventProgramUserLink EventProgramUserLink[] */
      $allEventProgramUserLink = $this->user->EventProgramUserLink(array('order' => 'EventProgramUserLink.Order'));

      $this->countEventView = 0;
      foreach ($eventUsersByEventId as $eUsers)
      {
        $view = $this->getSingleEventHtml($eUsers, $allEventProgramUserLink);

        if($this->countEventView > 3) {
          $invisibleEventViews->AddView($view);
        }
        else {
          $visibleEventViews->AddView($view);
        }
      }

      $result->EventVisible = $visibleEventViews;
      $result->EventInvisible = $invisibleEventViews;

      return $result;
    }

    return '';
  }


  /**
   * @param EventUser[] $eventUsers
   * @return array
   */
  private function transformEventUsersByEventId($eventUsers)
  {
    $result = array();
    foreach ($eventUsers as $eventUser)
    {
      if (!isset($result[$eventUser->EventId]))
      {
        $result[$eventUser->EventId] = array();
      }
      $result[$eventUser->EventId][] = $eventUser;
    }
    return $result;
  }

  const SpeakerRoleId = 3;
  private function getSingleEventHtml($eventUsers, $allEventProgramUserLink)
  {
    /** @var Event $event */
    $event = $eventUsers[0]->Event;

    if (empty($event) || $event->Visible == 'N')
    {
      return new ViewEmpty();
    }

    $this->countEventView++;

    $view = new View();
    $view->SetTemplate('event');
    $view->Event = $event;

    $roleIds = $this->getRoleIds($eventUsers);

    if (in_array(self::SpeakerRoleId, $roleIds))
    {
      $view->EventProgramUserLinks = $this->filterEventUserLinksByEventId($allEventProgramUserLink, $event->EventId);
    }

    $view->EventUsers = $eventUsers;

    return $view;
  }

  /**
   * @param EventUser[] $eventUsers
   * @return array
   */
  private function getRoleIds($eventUsers)
  {
    $roles = array();
    foreach ($eventUsers as $eUser)
    {
      $roles[] = $eUser->EventRole->RoleId;
    }
    return $roles;
  }

  private function filterEventUserLinksByEventId($allEventProgramUserLink, $eventId)
  {
    $eventUserLinks = array();
    foreach ($allEventProgramUserLink as $userLink)
    {
      if ($userLink->EventId == $eventId)
      {
        if (!isset($eventUserLinks[$userLink->EventProgramId]))
        {
          if (empty($userLink->EventProgram))
          {
            continue;
          }
          $eventUserLinks[$userLink->EventProgramId] = array(
            'section' => $userLink->EventProgram,
            'role' => $userLink->Role->Name
          );
        }
        else
        {
          $eventUserLinks[$userLink->EventProgramId]['role'] .= ', ' . $userLink->Role->Name;
        }
      }
    }

    return $eventUserLinks;
  }


  private function getActivityHtml()
  {
    $activities = $this->user->GetActivities();
    if (! empty($activities))
    {
      $result = new ViewContainer();

      foreach ($activities as $activity)
      {
        $view = new View();
        $view->SetTemplate('activity');

        $view->Type = $activity->Type;
        $view->Url = $activity->Url;
        $view->Title = $activity->Title;
        $view->Info = $activity->Info;

        $result->AddView($view);
      }

      return $result;
    }

    return '';
  }
}