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

    $criteria = new CDbCriteria();
    $criteria->condition = 't.VoteId = :VoteId';
    $criteria->params = array(':VoteId' => self::VoteId);
    $criteria->order = 't.CreationTime DESC';

    /** @var $results VoteResult[] */
    $results = VoteResult::model()->findAll($criteria);

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

    $temp = array();
    foreach ($userIdList as $id)
    {
      $temp['userid_'.$id] = null;
    }
    foreach ($users as $user)
    {
      $temp['userid_'.$user->UserId] = $user;
    }
    foreach ($temp as $key => $value)
    {
      if ($value == null)
      {
        unset($temp[$key]);
      }
    }


    $this->view->Users = $temp;

    echo $this->view;
  }
}
