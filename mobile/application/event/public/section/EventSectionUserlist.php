<?php
  
class EventSectionUserlist extends MobileCommand
{  
  private $section = null;
  
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
    $this->section = EventProgram::GetEventProgramById($sectionId, true);
    
    if (empty($this->section))
    {
      throw new Exception('Секция с идентификатором ' . $sectionId . ' не обнаружена.');
    }    
    
    $this->view->EventProgramId = $this->section->EventProgramId;
    $this->view->SectionTitle = $this->section->Title;
    $this->view->Start = date('H:i', strtotime($this->section->DatetimeStart));
    $this->view->End = date('H:i', strtotime($this->section->DatetimeFinish));
    
    $this->view->UserList = $this->getUserListHtml($this->section->UserHereList);
    
    echo $this->view;
  }
  
  private function getUserListHtml($userHereList)
  {
    $result = new ViewContainer();
    foreach ($userHereList as $hereInfo)
    {
      $view = new View();
      $view->SetTemplate('user');
      
      $view->FirstName = $hereInfo->User->GetFirstName();
      $view->LastName = $hereInfo->User->GetLastName();
      
      $result->AddView($view);
    }
    
    return $result;
  }

}