<?php
namespace ruvents\components;

class DataBuilder
{
  private $eventId;
  public function __construct($eventId)
  {
    $this->eventId = $eventId;
  }

  private $event = null;

  /**
   * @return \event\models\Event
   */
  public function Event()
  {
    if ($this->event == null)
    {
      $this->event = \event\models\Event::model()->findByPk($this->eventId);
    }

    return $this->event;
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

}
