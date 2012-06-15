<?php
AutoLoader::Import('comission.source.*');
 
class ComissionResult extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
//    if ($this->LoginUser == null || $this->LoginUser->RocId != 35287)
//    {
//      return;
//    }
    //return;
    $vote = ComissionVote::GetById(7);

    $this->view->Vote = $vote;
    $this->view->Questions = $vote->Questions(array('with' => array('Answers', 'Answers.Results', 'Answers.Results.User')));
    echo $this->view;
  }
}
