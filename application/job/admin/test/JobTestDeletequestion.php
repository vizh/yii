<?php
AutoLoader::Import('job.source.*');
 
class JobTestDeleteQuestion extends AjaxAdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $questionId = intval(Registry::GetRequestVar('QuestionId'));
    $question = JobTestQuestion::GetById($questionId);
    $testId = intval(Registry::GetRequestVar('TestId'));
    $result = array();
    if (! empty($question) && $question->TestId == $testId)
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
