<?php
AutoLoader::Import('comission.source.*');

class ComissionVoteProcess extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @param int $voteId
   * @param int $rocID
   * @param string $hash
   * @return void
   */
  protected function doExecute($voteId = 0, $rocID = 0, $hash = '')
  {
    $voteId = intval($voteId);
    $vote = ComissionVote::GetById($voteId);
    if (!empty($vote))
    {
      $rocID = intval($rocID);
      $user = User::GetByRocid($rocID);
      if ($hash === $vote->GetHash($rocID) && !empty($user))
      {
        $results = ComissionVoteResult::GetByVoteAndUser($vote->VoteId, $user->UserId);
        if (empty($results))
        {
          /** @var $questions ComissionVoteQuestion[] */
          $questions = $vote->Questions(array('with' => array('Answers')));
          if (Yii::app()->getRequest()->getIsPostRequest())
          {
            $answers = Registry::GetRequestVar('answers');
            if (sizeof($questions) === sizeof($answers))
            {
              foreach ($questions as $question)
              {
                if (isset($answers[$question->QuestionId]))
                {
                  foreach ($question->Answers as $answer)
                  {
                    if ($answers[$question->QuestionId] == $answer->AnswerId)
                    {
                      $result = new ComissionVoteResult();
                      $result->UserId = $user->UserId;
                      $result->VoteId = $vote->VoteId;
                      $result->QuestionId = $question->QuestionId;
                      $result->AnswerId = $answer->AnswerId;
                      $result->save();
                    }
                  }
                }
              }
              $this->view->SetTemplate('thank-you');
            }
            else
            {
              $this->view->Answers = $answers;
              $this->AddErrorNotice('Необходимо ответить на все вопросы');
            }
          }

          $this->view->Vote = $vote;
          $this->view->Questions = $questions;
        }
        else
        {
          $this->view->SetTemplate('sorry');
        }
      }
      else
      {
        $this->view->SetTemplate('no-hash');
      }
    }
    else
    {
      $this->view->SetTemplate('no-vote');
    }

    echo $this->view;
  }
}
