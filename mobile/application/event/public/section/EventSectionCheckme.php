<?php
  
class EventSectionCheckme extends MobileCommand
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
    $this->section = EventProgram::GetEventProgramById($sectionId);
    
    if (empty($this->section))
    {
      throw new Exception('Секция с идентификатором ' . $sectionId . ' не обнаружена.');
    }
    
    $here = $this->LoginUser->GetEventProgramHere();
    
    if ($here == null)
    {
      $here = new EventProgramHereService();
      
      $here->EventProgramId = $this->section->EventProgramId;
      $here->UserId = $this->LoginUser->GetUserId();
      $here->HereTime = date('Y-m-d H:i:s', time());
      $here->EndSectionTime = $this->section->DatetimeFinish;
      
      $here->save();
    }
    else
    {
      $here->EventProgramId = $this->section->EventProgramId;
      $here->HereTime = date('Y-m-d H:i:s', time());
      $here->EndSectionTime = $this->section->DatetimeFinish;

      $here->save();
    }
    
    $this->view->EventProgramId = $this->section->EventProgramId;
    $this->view->SectionTitle = $this->section->Title;
    
    echo $this->view;
  }

}