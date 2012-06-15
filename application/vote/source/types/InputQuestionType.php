<?php


class InputQuestionType extends BaseQuestionType
{

  /**
   * @param mixed $data
   * @param mixed $error
   * @return View
   */
  public function RenderQuestion($data, $error = false)
  {
    $view = new View();
    $view->SetTemplate('input', 'vote', 'questions', 'system');
    $view->Question = $this->question;
    if (! empty($data))
    {
      $view->Values = $data;
    }
    $view->Error = $error;
    return $view;
  }

  /**
   * @param mixed $data
   * @return bool
   */
  public function Validate($data)
  {
    $answerIdList = array();
    foreach ($this->question->Answers as $answer)
    {
      $answerIdList[] = $answer->AnswerId;
    }

    foreach ($data as $key => $value)
    {
      if (empty($value) && $this->question->Required == 1)
      {
        return false;
      }
      if (!in_array($key, $answerIdList))
      {
        return false;
      }
    }

    return true;
  }

  /**
   * @param $data
   * @return array
   */
  public function BuildData($data)
  {
    if ($this->Validate($data))
    {
      return $data;
    }
    return array();
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
        if ($result!== null && $result->Custom != null)
        {
          $data = unserialize(base64_decode($result->Custom));
          $data = !empty($data) ? $data : '-';
          $line[] = $this->forCsv($data);
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
