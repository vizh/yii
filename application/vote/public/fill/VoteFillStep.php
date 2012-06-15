<?php
AutoLoader::Import('vote.source.*');

class VoteFillStep extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    return;
    $voteId = 2;
    $count = 10;
    $startNumber = 160;
    $title = 'БЛОК В. Оценки рынка в целом. Рынок программного обеспечения как услуги (SaaS).';

    for ($i = 0; $i < $count; $i++)
    {
      $voteStep = new VoteStep();
      $voteStep->VoteId = $voteId;
      $voteStep->Number = $startNumber+$i;
      $voteStep->Title = $title;
      $voteStep->save();
    }

  }
}
