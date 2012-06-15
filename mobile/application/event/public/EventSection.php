<?php
  
class EventSection extends MobileCommand
{  
  private $section = null;
  private static $TimeDelta = 3600;
  
  private $actual = false;
  private $isRegisterOnEvent = false;
  private $likeReports = array();
  
  protected function preExecute()
  {
    parent::preExecute();    
    //Установка хеадера 
    $this->RedirectNonAuth();       
    
    $titles = Registry::GetWord('titles'); 
    $this->SetTitle($titles['mobile']);
  }
  
  protected function doExecute($sectionId = '')
  {
    $this->section = EventProgram::GetEventProgramById($sectionId);
    
    if (empty($this->section))
    {
      throw new Exception('Секция с идентификатором ' . $sectionId . ' не обнаружена.');
    }
    
    $this->actual = $this->isActual();
    $this->isRegisterOnEvent = $this->LoginUser->IsRegisterOnEvent($this->section->EventId);
    $this->likeReports = $this->getLikeReports();
    
//    $userLinksContainer = new ViewContainer();
//    foreach ($this->section->GetUserLinks() as $userlink)
//    {
//      $userLinksContainer->AddView($this->getUserLinkView($userlink));
//    }
    
    $this->view->EventProgramId = $this->section->EventProgramId;
    $this->view->SectionTitle = $this->section->Title;
    
    $this->view->Actual = $this->actual;
    $this->view->Start = date('H:i', strtotime($this->section->DatetimeStart));
    $this->view->End = date('H:i', strtotime($this->section->DatetimeFinish));
    $this->view->StartDate = strtotime($this->section->DatetimeStart) - self::$TimeDelta;
    $this->view->EndDate = strtotime($this->section->DatetimeFinish) + self::$TimeDelta;
//    $this->view->UserLinks = $userLinksContainer;
    
    $this->view->CanCheckHere = $this->isCanCheckHere($this->section->UserHereList) && $this->isRegisterOnEvent;
    $this->view->IsSectionFinish = strtotime($this->section->DatetimeFinish) < time();
    
    $this->view->IsSectionFinish = false;

    $this->fillUserLinks($this->section->GetUserLinks());
    
    echo $this->view;
  }
  
  /**
  * 
  * @param EventProgramUserLink $userLink
  * 
  * @return View
  */
  private function fillUserLinks($userLinks)
  {
    foreach ($userLinks as $userLink)
    {
      $view = new View();
      if ($userLink->Role->RoleId == 3)
      {
        $view->SetTemplate('userlink');

        $view->Role = $userLink->Role->Name;
        $view->Actual = $this->actual && $this->isRegisterOnEvent;

        $report = $userLink->Report;
        if ($report != null)
        {
          $view->Report = stripslashes($report->Header);
          $view->ReportId = $report->ReportId;
          $view->Actual = $view->Actual && ! in_array($report->ReportId, $this->likeReports);
        }
      }
      else
      {
        $view->SetTemplate('leaderlink');
        $view->Role = $userLink->Role->Name;

        $user = $userLink->User;
        $employments = $user->GetEmployments();
        foreach ($employments as $employment)
        {
          if ($employment->Primary == 1)
          {
            $company = $employment->GetCompany();
            if (! empty($company))
            {
              $view->CompanyName = trim($company->GetName());
              $view->CompanyPosition = trim($employment->Position);
            }
            else
            {
              Lib::log('Message: Empty Company, but no empty employment.  Trace string: getUsersHtml in application/user/UserList.php ', CLogger::LEVEL_ERROR, 'application');
            }
            break;
          }
        }
      }


      $view->FirstName = $userLink->User->FirstName;
      $view->LastName = $userLink->User->LastName;

      if ($userLink->Role->RoleId == 3)
      {
        $this->view->UserLinks .= $view;
      }
      else
      {
        $this->view->LeaderLinks .= $view;
      }
    }
    
    return $view;
  }
  
  private function isCanCheckHere($userHereList)
  {
    foreach ($userHereList as $hereInfo)
    {
      if ($hereInfo->UserId == $this->LoginUser->GetUserId())
      {
        return false;
      }
    }
    
    return true;
  }
  
  private function isActual()
  {
    $start = strtotime($this->section->DatetimeStart) - self::$TimeDelta;
    $end = strtotime($this->section->DatetimeFinish) + self::$TimeDelta;
    $now = time();
    return $start < $now && $now < $end;
  }  
  
  private function getLikeReports()
  {
    $likeReports = EventReportLike::GetEventReportLikePersonal($this->LoginUser->GetUserId());
    $result = array();
    foreach ($likeReports as $like)
    {
      $result[] = $like->ReportId;
    }
    return $result;
  }
}