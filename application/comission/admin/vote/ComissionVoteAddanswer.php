<?php
AutoLoader::Import('comission.source.*');
 
class ComissionVoteAddanswer extends AjaxAdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $questionId = Registry::GetRequestVar('QuestionId');
    $return = array();
    if ($questionId != null && intval($questionId) != 0)
    {
      $answer = new ComissionVoteAnswer();
      $answer->QuestionId = intval($questionId);
      $answer->save();

      $view = new View();
      $view->SetTemplate('answer');
      $view->AnswerId = $answer->AnswerId;

      $return['error'] = false;
      $return['data'] = (string) $view;
      $return['question'] = $answer->QuestionId;
    }
    else
    {
      $return['error'] = true;
    }
    echo json_encode($return);
  }
}