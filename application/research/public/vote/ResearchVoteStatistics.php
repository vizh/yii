<?php
AutoLoader::Import('vote.source.*');

class ResearchVoteStatistics extends GeneralCommand
{

  public static $Access = array(35287, 454, 337, 12959, 49465, 15648, 2889, 16670, 2889, 101542, 12953);

  const VoteId = 2;


  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    if (empty($this->LoginUser) || !in_array($this->LoginUser->RocId, self::$Access))
    {
      $this->Send404AndExit();
    }

    /** @var $results VoteResult[] */
    $results = VoteResult::model()->findAll('t.VoteId = :VoteId', array(':VoteId' => self::VoteId));

    $userIdList = array();
    $resultIdList = array();
    foreach ($results as $result)
    {
      $info = $result->GetVoterInfo();
      $userId = $info['UserId'];
      if ($userId != 34528)
      {
        $userIdList[] = $userId;
        $resultIdList[] = $result->ResultId;
      }
    }

    $criteria = new CDbCriteria();
    $criteria->addInCondition('t.UserId', $userIdList);
    $users = User::model()->findAll($criteria);

    $this->view->Users = $users;

    echo $this->view;
  }
}
