<?php
AutoLoader::Import('comission.source.*');
 
class ComissionVoteDeletequestion extends AjaxAdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $questionId = intval(Registry::GetRequestVar('QuestionId'));
    $question = ComissionVoteQuestion::GetById($questionId);
    $voteId = intval(Registry::GetRequestVar('VoteId'));
    $result = array();
    if (! empty($question) && $question->VoteId == $voteId)
    {
      $question->delete();
      $result['error'] = false;
      $result['question'] = $questionId;
    }
    else
    {
      $result['error'] = true;
    }
    echo json_encode($result);
  }
}