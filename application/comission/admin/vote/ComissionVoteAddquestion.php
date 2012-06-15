<?php
AutoLoader::Import('comission.source.*');
 
class ComissionVoteAddquestion extends AjaxAdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $voteId = Registry::GetRequestVar('VoteId');
    $return = array();
    if ($voteId != null && intval($voteId) != 0)
    {
      $question = new ComissionVoteQuestion();
      $question->VoteId = intval($voteId);
      $question->Question = Registry::GetRequestVar('Question');
      $question->save();



      $view = new View();
      $view->SetTemplate('question');
      $view->QuestionId = $question->QuestionId;
      $view->Question = $question->Question;

      $return['error'] = false;
      $return['data'] = (string) $view;
    }
    else
    {
      $return['error'] = true;
    }
    echo json_encode($return);
  }
}
