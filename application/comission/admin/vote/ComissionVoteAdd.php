<?php
AutoLoader::Import('comission.source.*');
 
class ComissionVoteAdd extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $vote = new ComissionVote();
    $vote->Status = ComissionVote::StatusDraft;
    $vote->CreationTime = date('Y-m-d H:i:s');
    $vote->save();

    Lib::Redirect(RouteRegistry::GetAdminUrl('comission', 'vote', 'edit', array('id' => $vote->VoteId)));
  }
}
