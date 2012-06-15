<?php
AutoLoader::Import('job.source.*');
 
class JobTestAddanswer extends AjaxAdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $testId = Registry::GetRequestVar('TestId');
    $questionId = Registry::GetRequestVar('QuestionId');
    $return = array();
    if ($questionId != null && intval($questionId) != 0)
    {
      $answer = new JobTestAnswer();
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
