<?php
AutoLoader::Import('comission.source.*');
 
class ComissionVoteIndex extends AdminCommand
{
  const CountByPage = 30;

  /**
   * Основные действия комманды
   * @param int $page
   * @return void
   */
  protected function doExecute($page = 1)
  {
    $votes = ComissionVote::GetByPage(self::CountByPage, $page, null, null, true);

    foreach ($votes as $vote)
    {
      $view = new View();
      $view->SetTemplate('vote');
      $view->Vote = $vote;
      $this->view->Votes .= $view;
    }

    echo $this->view;
  }
}
