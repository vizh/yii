<?php
AutoLoader::Import('comission.source.*');
 
class ComissionVoteEdit extends AdminCommand
{

  protected function preExecute()
  {
    parent::preExecute();

    $this->view->HeadScript(array('src'=>'/js/libs/tiny_mce/tiny_mce.js'));
    $this->view->HeadScript(array('src'=>'/js/admin/vote.edit.js'));
  }

  /**
   * Основные действия комманды
   * @param int $id
   * @return void
   */
  protected function doExecute($id = 0)
  {
    $id = intval($id);
    $vote = ComissionVote::GetById($id);
    if (empty($vote))
    {
      Lib::Redirect(RouteRegistry::GetAdminUrl('comission', 'vote', 'index'));
    }

    if (Yii::app()->getRequest()->getIsPostRequest())
    {
      $data = Registry::GetRequestVar('data');

      $words = Registry::GetWord('news');
      $data['title'] = $data['title'] !== $words['entertitle'] ? $data['title'] : '';
      // Параметры теста
      $vote->Title = $data['title'];
      $description = $data['description'];
      $purifier = new CHtmlPurifier();
      $purifier->options = array('HTML.AllowedElements' => array('p', 'ul', 'ol', 'li', 'strong', 'em'),
                                 'HTML.AllowedAttributes' => '');
      $description = $purifier->purify($description);
      $vote->Description = $description;
      $vote->Status = $data['status'];
      $vote->ComissionId = $data['comission'] != -1 ? intval($data['comission']) : null;

      $vote->save();
      
      foreach ($vote->Questions as $question)
      {
        if ($question->Question !== $data['question'][$question->QuestionId])
        {
          $question->Question = $data['question'][$question->QuestionId];
          $question->save();
        }

        foreach ($question->Answers as $answer)
        {
          if ($answer->Answer != $data['answer'][$answer->AnswerId])
          {
            $answer->Answer = $data['answer'][$answer->AnswerId];
            $answer->save();
          }
        }
      }
    }

    $this->view->Comissions = Comission::GetAll();
    $this->view->Vote = $vote;

    echo $this->view;
  }
}
