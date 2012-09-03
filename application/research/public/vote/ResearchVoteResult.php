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

    /** @var $users User[] */
    $users = array();
    $resultIdList = array();
    foreach ($results as $result)
    {
      $info = $result->GetVoterInfo();
      $userId = $info['UserId'];
      $users[] = User::GetById($userId);
      if ($userId != 34528)
      {
        $resultIdList[] = $result->ResultId;
      }
    }

    $data = array(
      'RocId' => array('-', '-'),
      'FullName' => array('-', '-'),
      'Company' => array('-', '-'),
      'Position' => array('-', '-')
    );
    foreach ($users as $user)
    {
      if ($user == null)
      {
        $data['RocId'][] = '-';
        $data['FullName'][] = '-';
        $data['Company'][] = '-';
        $data['Position'][] = '-';
        continue;
      }
      $data['RocId'][] = iconv('utf-8', 'Windows-1251', $user->RocId);
      $data['FullName'][] = iconv('utf-8', 'Windows-1251', $user->GetFullName());
      $employment = $user->EmploymentPrimary();
      if (!empty($employment))
      {
        $data['Company'][] = iconv('utf-8', 'Windows-1251', $employment->Company->Name);
        $data['Position'][] = iconv('utf-8', 'Windows-1251', $employment->Position);
      }
      else
      {
        $data['Company'][] = '-';
        $data['Position'][] = '-';
      }
    }

    $path = $_SERVER['DOCUMENT_ROOT'] . '/files/i-research/research.csv';

    $file = $file = fopen($path, 'w');
    fputcsv($file, $data['RocId'], ';');
    fputcsv($file, $data['FullName'], ';');
    fputcsv($file, $data['Company'], ';');
    fputcsv($file, $data['Position'], ';');

    /** @var $vote Vote */
    $vote = Vote::model()->findByPk(ResearchVoteStatistics::VoteId);

    $vote->ResultCsv($path, $resultIdList, $file);

    echo 'Результат успешно сгенерирован!<br>';
    echo '<a href="http://rocid.ru/files/i-research/research.csv">Скачать!</a>';
  }
}
