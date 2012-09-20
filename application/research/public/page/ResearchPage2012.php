<?php
AutoLoader::Import('vote.source.*');
AutoLoader::Import('research.public.vote.ResearchVoteStatistics');

class ResearchPage2012 extends GeneralCommand
{
  protected function doExecute() 
  {
    $voteResults = VoteResult::model()->findAll('t.VoteId = :VoteId', array(':VoteId' => ResearchVoteStatistics::VoteId));
    $userIdList = array();
    foreach ($voteResults as $result)
    {
      $info = $result->GetVoterInfo();
      $userIdList[] = $info['UserId'];
    }
    $criteria = new CDbCriteria();
    $criteria->with = array(
      'Employments'
    );
    $criteria->addInCondition('t.UserId', $userIdList);
    $this->view->Experts = User::model()->findAll($criteria);
   
    $this->SetTitle('Экономика Рунета 2012');
    echo $this->view;
  }
}
