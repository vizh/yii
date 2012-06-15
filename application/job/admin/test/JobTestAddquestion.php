<?php
AutoLoader::Import('job.source.*');
 
class JobTestAddquestion extends AjaxAdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $testId = Registry::GetRequestVar('TestId');
    $return = array();
    if ($testId != null && intval($testId) != 0)
    {
      $question = new JobTestQuestion();
      $question->TestId = intval($testId);
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
