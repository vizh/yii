<?php
  
class EventSectionLike extends MobileCommand
{  
  private $report = null;
  
  protected function preExecute()
  {
    parent::preExecute();
    //Установка хеадера        
    $this->RedirectNonAuth();
    
    $titles = Registry::GetWord('titles'); 
    $this->SetTitle($titles['mobile']);
  }
  
  protected function doExecute($reportId = '')
  {
    $this->report = EventReports::GetEventReportById($reportId);
    
    if (empty($this->report))
    {
      throw new Exception('Секция с идентификатором ' . $reportId . ' не обнаружена.');
    }
    
    $here = $this->LoginUser->GetEventProgramHere();
    
    EventReportLike::LikeIt($this->report->ReportId, $this->LoginUser->GetUserId());    
    
    $this->view->ReportId = $this->report->ReportId;
    $this->view->ReportTitle = $this->report->Header;
    
    echo $this->view;
  }

}