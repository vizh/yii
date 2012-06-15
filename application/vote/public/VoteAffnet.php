<?php
AutoLoader::Import('vote.source.*');

class VoteAffnet extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $this->view->HeadScript(array('src'=>'/js/vote.js'));

    /** @var $vote Vote */
    $vote = Vote::model()->findByPk(1);
    if ($vote->VoteManager()->CheckVoter())
    {
      if (Yii::app()->getRequest()->getIsPostRequest())
          {
            $view = $vote->VoteManager()->NextStep();
            if ($view !== null)
            {
              $this->view->Step = $view;
            }
            else
            {
              $vote->VoteManager()->FinishVote();
              $this->view->SetTemplate('end');
            }
          }
          else
          {
            $this->view->SetTemplate('start');
          }
    }
    else
    {
      $this->view->SetTemplate('error');
    }

    echo $this->view;
  }
}
