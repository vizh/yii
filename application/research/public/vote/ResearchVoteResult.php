<?php
AutoLoader::Import('vote.source.*');
AutoLoader::Import('research.public.vote.ResearchVoteStatistics');

class ResearchVoteResult extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    if (empty($this->LoginUser) || !in_array($this->LoginUser->RocId, ResearchVoteStatistics::$Access))
    {
      $this->Send404AndExit();
    }

    /** @var $results VoteResult[] */
    $results = VoteResult::model()->findAll('t.VoteId = :VoteId', array(':VoteId' => ResearchVoteStatistics::VoteId));

    $resultIdList = array();
    foreach ($results as $result)
    {
      $info = $result->GetVoterInfo();
      $userId = $info['UserId'];
      if ($userId != 34528)
      {
        $resultIdList[] = $result->ResultId;
      }
    }

    /** @var $vote Vote */
    $vote = Vote::model()->findByPk(ResearchVoteStatistics::VoteId);

    $vote->ResultCsv($_SERVER['DOCUMENT_ROOT'] . '/files/i-research/research.csv', $resultIdList);

    echo 'Результат успешно сгенерирован!<br>';
    echo '<a href="http://rocid.ru/files/i-research/research.csv">Скачать!</a>';
  }
}
