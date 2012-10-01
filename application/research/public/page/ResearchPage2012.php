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
    $criteria->condition = 't.EventId = :EventId';
    $criteria->params[':EventId'] = '369';
    $this->view->Experts = EventUser::model()->findAll($criteria);
   
    $this->SetTitle('Экономика Рунета 2012');
    echo $this->view;
  }
}
