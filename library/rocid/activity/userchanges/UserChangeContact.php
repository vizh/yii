<?php
AutoLoader::Import('library.rocid.activity.userchanges.*');

class UserChangeContact extends UserBaseChange
{
  private static $type = array('service', 'site');

  public $ContactValue;
  public $ContactServiceId;
  public $ContactType;

  /**
   * @static
   * @param int $userId
   * @param string $contactValue
   * @param int|string $serviceId
   * @param string $contactType service or site
   * @return void
   */
  public static function Add($userId, $contactValue, $serviceId, $contactType = 'service')
  {
    $change = new UserChangeContact();
    $change->ContactValue = $contactValue;
    $change->ContactServiceId = $serviceId;
    $change->ContactType = $contactType;

    self::Save($userId, $change);
  }

  /**
   * @var null|ContactServiceType[]
   */
  private static $serviceTypes = null;

  public function __construct()
  {

  }

  /**
   * @return ContactServiceType[]|null
   */
  private function GetServiceTypes()
  {
    if (self::$serviceTypes == null)
    {
      self::$serviceTypes = ContactServiceType::GetAll();
    }
    return self::$serviceTypes;
  }

  public function GetView()
  {
    $view = new View();
    $view->SetTemplate('contact', 'core', 'userchanges', 'activity', 'public');

    $view->FirstName = $this->user->FirstName;
    $view->LastName = $this->user->LastName;
    $view->RocId = $this->user->RocId;

    if ($this->ContactType == 'service')
    {
      $services = $this->GetServiceTypes();
      $view->ContactName = isset($services[$this->ContactServiceId]) ?
          $services[$this->ContactServiceId]->Title : '';
    }
    else
    {
      $view->ContactName = 'Cайт';
    }
    $view->ContactValue = $this->ContactValue;

    return $view;
  }
}