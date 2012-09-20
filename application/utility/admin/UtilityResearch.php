<?php
/**
 * Проставляет статус "Эксперт" участникам голосования 
 */
AutoLoader::Import('vote.source.*');
AutoLoader::Import('research.public.vote.ResearchVoteStatistics');

class UtilityResearch  extends AdminCommand
{
  private $eventId = 369;
  private $roleId  = 19;
  

  public function doExecute() 
  {
    return;
    $voteResults = VoteResult::model()->findAll('t.VoteId = :VoteId', array(':VoteId' => ResearchVoteStatistics::VoteId));
    $userIdList = array();
    foreach ($voteResults as $result)
    {
      $info = $result->GetVoterInfo();
      $userIdList[] = $info['UserId'];
    }
    $criteria = new CDbCriteria();
    $criteria->addInCondition('t.UserId', $userIdList);
    $users = User::model()->findAll($criteria);
    
    $event = Event::GetById($this->eventId);
    if ($event !== null)
    {
      $role  = EventRoles::GetById($this->roleId);
      foreach ($users as $user)
      {
        $event->RegisterUser($user, $role);
      }
      echo 'OK';
    }
  }
}
