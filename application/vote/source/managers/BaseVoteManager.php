<?php

abstract class BaseVoteManager
{
  /**
   * @var Vote
   */
  protected $vote;

  /**
   * @param Vote $vote
   */
  public function __construct($vote)
  {
    $this->vote = $vote;
  }

  /**
   * @return View|null Возвращает null, если нет доступных для рендеринга шагов
   */
  public function NextStep()
  {
    $canReset = false;
    $step = $this->getStep();
    $back = Registry::GetRequestVar('Back', 0);
    $goBack = false;
    if ($back == 0)
    {
      if ($step !== null)
      {
        $step += $this->buildStepData() ? 1 : 0;
      }
      else
      {
        $lastStep = $this->getLastStep();
        if ($lastStep === null)
        {
          $step = 0;
          $this->resetStepData();
        }
        else
        {
          $canReset = true;
          $step = intval($lastStep);
        }
      }
    }
    else
    {
      if ($step > 0)
      {
        $step -= 1;
        $goBack = true;
      }
      else
      {
        $step = 0;
      }
    }

    return $this->RenderStep($step, $canReset, $goBack);
  }

  /**
   * @return bool
   */
  public function InProgress()
  {
    $lastStep = $this->getLastStep();
    return $lastStep !== null;
  }

  /**
   * @abstract
   * @return bool
   */
  public abstract function CheckVoter();

  /**
   * @param int $step
   * @param bool $canReset
   * @param bool $goBack
   * @return View|null Возвращает null, если нет шага с номером $step
   */
  public function RenderStep($step, $canReset = false, $goBack = false)
  {
    $voteStep = VoteStep::GetByNumber($this->vote->VoteId, $step);
    if (empty($voteStep))
    {
      return null;
    }
    $questions = VoteQuestion::GetByStep($this->vote->VoteId, $voteStep->StepId, $this->getAnswerIdList($step));

    if (empty($questions))
    {
      $nextStepDelta = $goBack ? -1 : 1;
      return $this->RenderStep($step+$nextStepDelta, $canReset, $goBack);
    }

    $view = new View();
    $view->SetTemplate('vote', 'vote', 'system', '', 'public');
    $view->Step = $voteStep;
    $view->CountQuestions = $voteStep->GetCountQuestions($this->getAnswerIdList($step));
    $view->CanReset = $canReset;

    $this->stepData = $this->getStepData($step);
    foreach ($questions as $question)
    {
      $data = isset($this->stepData[$question->QuestionId]) ? $this->stepData[$question->QuestionId] : null;
      $error = isset($this->errors[$question->QuestionId]) ? $this->errors[$question->QuestionId] : false;
      $view->Questions .= $question->QuestionType()->RenderQuestion($data, $error);
    }
    return $view;
  }

  protected function getStep()
  {
    return Registry::GetRequestVar('Step', null);
  }

  public function ResetVote()
  {
    $this->resetStepData();
  }

  /** @var array|null */
  protected $stepData = null;

  /**
   * @return bool
   */
  protected function buildStepData()
  {
    if ($this->stepData !== null)
    {
      return empty($this->errors);
    }

    $this->errors = array();
    $this->stepData = array();
    $step = $this->getStep();
    $voteStep = VoteStep::GetByNumber($this->vote->VoteId, $step);
    if (empty($voteStep))
    {
      return true;
    }

    $questions = VoteQuestion::GetByStep($this->vote->VoteId, $voteStep->StepId, $this->getAnswerIdList($step));
    $data = Registry::GetRequestVar('Questions');

    foreach ($questions as $question)
    {
      if ($question->CheckDepends($data))
      {
        $qData = isset($data[$question->QuestionId]) ?  $data[$question->QuestionId] : null;
        $this->stepData[$question->QuestionId] = $question->QuestionType()->BuildData($qData);
        if (! $question->QuestionType()->Validate($qData))
        {
          $this->errors[$question->QuestionId] = true;
        }
      }
    }

    $this->stepData = $this->processStepData($step, $this->stepData);

    return empty($this->errors);
  }

  protected $errors = null;
  protected function getErrors()
  {
    if ($this->errors === null)
    {
      $this->buildStepData();
    }

    return $this->errors;
  }


//  protected function validateStepData()
//  {
//    if ($this->getStep() == 0)
//    {
//      $this->errors = array();
//      return false;
//    }
//    if ($this->errors === null)
//    {
//
//    }
//
//    return empty($this->errors);
//  }

  protected function sessionKey()
  {
    return 'vote_' . $this->vote->VoteId;
  }

  protected function resetStepData()
  {
    Registry::GetSession()->remove($this->sessionKey());
  }

  /**
   * @param int $step
   * @param array $data ключ - QuestionId, значение  - массив с ключами AnswerId, значениями bool или параметр
   */
  protected function processStepData($step, $data)
  {
    $sessionData = Registry::GetSession()->get($this->sessionKey(), array());
    foreach ($data as $key => $value)
    {
      $sessionData[$step][$key] = $value;
    }
    Registry::GetSession()->add($this->sessionKey(), $sessionData);
  }

  protected function getStepData($step)
  {
    $sessionData = Registry::GetSession()->get($this->sessionKey(), array());
    return isset($sessionData[$step]) ?  $sessionData[$step] : array();
  }

  /**
   * @param int $currentStep
   * @return int[]
   */
  protected function getAnswerIdList($currentStep)
  {
    $result = array();
    $sessionData = Registry::GetSession()->get($this->sessionKey(), array());
    foreach ($sessionData as $key => $step)
    {
      if ($key == $currentStep)
      {
        continue;
      }
      foreach ($step as $value)
      {
        $result = array_merge($result, array_keys($value));
      }
    }
    return $result;
  }

  /**
   * @return mixed|null
   */
  protected function getLastStep()
  {
    $sessionData = Registry::GetSession()->get($this->sessionKey(), array());
    if (!empty($sessionData))
    {
      end($sessionData);
      return key($sessionData);
    }
    return null;
  }

  /**
   * @abstract
   * @return string
   */
  protected abstract function getVoterHash();

  /**
   * @abstract
   * @return string
   */
  protected abstract function getVoterInfo();

  /**
   * @abstract
   *
   */
  protected abstract function afterFinishVote();

  public function FinishVote()
  {
    $sessionData = Registry::GetSession()->get($this->sessionKey(), array());

    $result = new VoteResult();
    $result->VoteId = $this->vote->VoteId;
    $result->Hash = $this->getVoterHash();
    $result->Info = $this->getVoterInfo();
    $result->CreationTime = date('Y-m-d H:i:s');
    $result->save();

    foreach ($sessionData as $questions)
    {
      foreach ($questions as $question)
      {
        foreach ($question as $key => $answer)
        {
          $resultAnswer = new VoteResultAnswer();
          $resultAnswer->ResultId = $result->ResultId;
          $resultAnswer->AnswerId = $key;
          if (is_array($answer) || is_string($answer))
          {
            $resultAnswer->Custom = base64_encode(serialize($answer));
          }
          else
          {
            $resultAnswer->Custom = null;
          }
          $resultAnswer->save();
        }
      }
    }

    $this->afterFinishVote();
  }

}