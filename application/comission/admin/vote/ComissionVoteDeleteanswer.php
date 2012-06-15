<?php
AutoLoader::Import('comission.source.*');
 
class ComissionVoteDeleteanswer extends AjaxAdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $answerId = intval(Registry::GetRequestVar('AnswerId'));
    $answer = ComissionVoteAnswer::GetById($answerId);
    $result = array();
    if (! empty($answer))
    {
      $answer->delete();
      $result['error'] = false;
      $result['answer'] = $answerId;
    }
    else
    {
      $result['error'] = true;
    }
    echo json_encode($result);
  }
}