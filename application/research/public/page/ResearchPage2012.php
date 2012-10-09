<?php
AutoLoader::Import('vote.source.*');
AutoLoader::Import('research.public.vote.ResearchVoteStatistics');

class ResearchPage2012 extends GeneralCommand
{
  protected function doExecute() 
  {
    $criteria = new CDbCriteria();
    $criteria->with = array(
      'User',
      'User.Employments',
      'User.Settings'
    );
    $criteria->order = 'User.LastName ASC';
    $criteria->condition = 't.EventId = :EventId';
    $criteria->params[':EventId'] = '369';
    $experts = EventUser::model()->findAll($criteria);
    
    foreach ($experts as $expert)
    {
      $userView = new View();
      $userView->SetTemplate('user');
      $userView->user = $expert->User;
      $this->view->Experts .= $userView;
    }
    
    
    $criteria->params[':EventId'] = '368';
    $participants = EventUser::model()->findAll($criteria);
    $viewParticipants = array(
      'Roles' => array(), 'Users' => array()
    );
    
    foreach ($participants as $participant)
    {
      if (!isset($viewParticipants['Roles'][$participant->RoleId]))
      {
        $viewParticipants['Roles'][$participant->RoleId] = $participant->Role->Name;
        $viewParticipants['Users'][$participant->RoleId] = '';
      }
      
      $userView = new View();
      $userView->SetTemplate('user');
      $userView->user = $participant->User;
      $viewParticipants['Users'][$participant->RoleId] .= $userView; 
    }
    $this->view->Participants = $viewParticipants;
    
    
    $this->SetTitle('Экономика Рунета 2012');
    echo $this->view;
  }
}
