<?php
AutoLoader::Import('library.rocid.activity.userchanges.*');
 
class UserChangeWork extends UserBaseChange
{
  public $CompanyId;
  public $CompanyName;
  /**
   * @var string $Start Y-m-d
   */
  public $Start;
  /**
   * @var string $Finish Y-m-d
   */
  public $Finish;

  /**
   * @static
   * @param int $userId
   * @param int $companyId
   * @param string $companyName
   * @param string $start Y-m-d
   * @param string $finish Y-m-d
   * @return void
   */
  public static function Add($userId, $companyId, $companyName, $start, $finish)
  {
    $change = new UserChangeWork();
    $change->CompanyId = $companyId;
    $change->CompanyName = $companyName;
    $change->Start = $start;
    $change->Finish = $finish;

    self::Save($userId, $change);
  }

  public function __construct()
  {
    
  }

  public function GetView()
  {
    $view = new View();
    $view->SetTemplate('work', 'core', 'userchanges', 'activity',  'public');

    $view->FirstName = $this->user->FirstName;
    $view->LastName = $this->user->LastName;
    $view->RocId = $this->user->RocId;

    $view->CompanyId = $this->CompanyId;
    $view->CompanyName = $this->CompanyName;
    $view->Start = getdate(strtotime($this->Start));
    if (! empty($this->Finish))
    {
      $view->Finish = getdate(strtotime($this->Finish));
    }

    return $view;
  }
}
