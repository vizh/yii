<?php
namespace ruvents\components;

class DataBuilder
{
  private $eventId;
  public function __construct($eventId)
  {
    $this->eventId = $eventId;
  }

  private $activeEvent = null;

  /**
   * @return \event\models\Event
   */
  public function Event()
  {
    if ($this->activeEvent == null)
    {
      $this->activeEvent = \event\models\Event::model()->findByPk($this->eventId);
    }

    return $this->activeEvent;
  }

  protected $user;
  /**
   * @param \user\models\User $user
   * @return \stdClass
   */
  public function CreateUser($user)
  {
    $this->user = new \stdClass();

    $this->user->RocId = $user->RocId;
    $this->user->LastName = $user->LastName;
    $this->user->FirstName = $user->FirstName;
    $this->user->FatherName = $user->FatherName;

    $this->user->Photo = new \stdClass();
    $this->user->Photo->Small = $user->GetMiniPhoto();
    $this->user->Photo->Medium = $user->GetMediumPhoto();
    $this->user->Photo->Large = $user->GetPhoto();

    return $this->user;
  }

  /**
   * @param \user\models\User $user
   * @return \stdClass
   */
  public function BuildUserEmail($user)
  {
    if (!empty($user->Emails))
    {
      $this->user->Email = $user->Emails[0]->Email;
    }
    else
    {
      $this->user->Email = $user->Email;
    }

    return $this->user;
  }

  /**
   * @param \user\models\User $user
   * @return \stdClass
   */
  public function BuildUserEmployment($user)
  {
    foreach ($user->Employments as $employment)
    {
      if ($employment->Primary == 1 && !empty($employment->Company))
      {
        $this->user->Work = new \stdClass();
        $this->user->Work->Position = $employment->Position;
        $this->user->Work->Company = $this->CreateCompany($employment->Company);
        $this->user->Work->Start = $employment->StartWorking;
        $this->user->Work->Finish = $employment->FinishWorking;
        return $this->user;
      }
    }

    return $this->user;
  }

  /**
   * @param \user\models\User $user
   * @return \stdClass
   */
  public function BuildUserEvent($user)
  {
    $isSingleDay = empty($this->Event()->Days);
    foreach ($user->Participants as $participant)
    {
      if ($participant->EventId == $this->eventId)
      {
        if ($isSingleDay)
        {
          $this->user->Status = new \stdClass();
          $this->user->Status->RoleId = $participant->RoleId;
          $this->user->Status->RoleName = $participant->Role->Name;
          $this->user->Status->UpdateTime = $participant->UpdateTime;
          //todo: добавить поле UpdateTime, переделать эти поля в timestamp
        }
        else
        {
          if (!isset($this->user->Status))
          {
            $this->user->Status = array();
          }
          $status = new \stdClass();
          $status->DayId = $participant->DayId;
          $status->RoleId = $participant->RoleId;
          $status->RoleName = $participant->Role->Name;
          $status->UpdateTime = $participant->UpdateTime;
          $this->user->Status[] = $status;
        }
      }
    }

    return $this->user;
  }

  protected $company;
  /**
   * @param \company\models\Company $company
   * @return \stdClass
   */
  public function CreateCompany($company)
  {
    $this->company = new \stdClass();

    $this->company->CompanyId = $company->CompanyId;
    $this->company->Name = $company->Name;

    return $this->company;
  }

  protected $event;
  /**
   *
   */
  public function CreateEvent()
  {
    $this->event = new \stdClass();

    $this->event->EventId = $this->Event()->EventId;
    $this->event->IdName = $this->Event()->IdName;
    $this->event->Name = $this->Event()->Name;
    $this->event->Info = $this->Event()->Info;
    $this->event->Place = $this->Event()->Place;
    $this->event->Url = $this->Event()->Url;
    $this->event->UrlRegistration = $this->Event()->UrlRegistration;
    $this->event->UrlProgram = $this->Event()->UrlProgram;
    $this->event->DateStart = $this->Event()->DateStart;
    $this->event->DateEnd = $this->Event()->DateEnd;

    $this->event->Image = new \stdClass();
    $this->event->Image->Mini = 'http://rocid.ru' . $this->Event()->GetMiniLogo();
    $this->event->Image->Normal = 'http://rocid.ru' . $this->Event()->GetLogo();

    $this->event->Days = array();
    foreach ($this->Event()->Days as $day)
    {
      $resultDay = new \stdClass();
      $resultDay->DayId = $day->DayId;
      $resultDay->Title = $day->Title;
      $resultDay->Order = $day->Order;

      $this->event->Days[] = $resultDay;
    }

    return $this->event;
  }

  protected $badge;

  /**
   * @param \ruvents\models\Badge $badge
   */
  public function CreateBadge($badge)
  {
    $this->badge = new \stdClass();

    $this->badge->RocId = $badge->User->RocId;
    $this->badge->RoleId = $badge->RoleId;
    $this->badge->RoleName = $badge->Role->Name;
    $this->badge->DayId = $badge->DayId;
    $this->badge->OperatorId = $badge->OperatorId;

    return $this->badge;
  }
}
