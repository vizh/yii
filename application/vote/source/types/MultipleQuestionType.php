<?php


class MultipleQuestionType extends BaseQuestionType
{

  /**
   * @param mixed $data
   * @param mixed $error
   * @return View
   */
  public function RenderQuestion($data, $error = false)
  {
    $view = new View();
    $view->SetTemplate('multiple', 'vote', 'questions', 'system');
    $view->Question = $this->question;
    $view->Checked = !empty($data) ? $data : array();
    $view->Error = $error;
    return $view;
  }

  /**
   * @param array $data
   * @return bool
   */
  public function Validate($data)
  {
    if (empty($data))
    {
      return $this->question->Required == 0;
    }

    /** @var $answerList VoteAnswer[] */
    $answerList = array();
    foreach ($this->question->Answers as $answer)
    {
      $answerList[$answer->AnswerId] = $answer;
    }

    foreach ($data as $value)
    {
      if (isset($answerList[$value]))
      {
        if ($answerList[$value]->Custom == 1)
        {
          $value = $this->getCustomValue($answerList[$value]);
          if ($value === null || strlen($value) == 0)
          {
            return false;
          }
        }
      }
      else
      {
        return false;
      }
    }
    return true;
  }

  /**
   * @param array $data
   * @return array
   */
  public function BuildData($data)
  {
    $result = array();
    if (empty($data))
    {
      return $result;
    }

    foreach ($this->question->Answers as $answer)
    {
      if (in_array($answer->AnswerId, $data))
      {
        $result[$answer->AnswerId] = true;
        if ($answer->Custom == 1)
        {
          $value = $this->getCustomValue($answer);
          if ($value !== null && strlen($value) > 0)
          {
            $result[$answer->AnswerId] = $value;
          }
        }
      }
    }
    return $result;
  }

  public function ResultCsv($file, $resultIdList)
  {
    $keys = array_keys($resultIdList);
    foreach ($this->question->Answers as $answer)
    {
      $localResultList = $resultIdList;
      $results = $answer->GetResults($keys);
      foreach ($results as $result)
      {
        $localResultList[$result->ResultId] = $result;
      }
      $line = array();
      $line[] = $this->forCsv($answer->Answer);
      $line[] = sizeof($results);

      foreach ($localResultList as $result)
      {
        if ($result !== null)
        {
          if ($result->Custom != null)
          {
            $data = unserialize(base64_decode($result->Custom));
            $data = !empty($data) ? $data : '-';
            $line[] = $this->forCsv($data);
          }
          else
          {
            $line[] = 1;
          }
        }
        else
        {
          $line[] = '';
        }
      }

      fputcsv($file, $line, ';');
    }
  }
}
