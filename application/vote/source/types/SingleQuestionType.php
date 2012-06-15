<?php

class SingleQuestionType extends BaseQuestionType
{

  /**
   * @param mixed $data
   * @param mixed $error
   * @return View
   */
  public function RenderQuestion($data, $error = false)
  {
    $view = new View();
    $view->SetTemplate('single', 'vote', 'questions', 'system');
    $view->Question = $this->question;
    if (! empty($data))
    {
      $keys = array_keys($data);
      $view->Checked = $keys[0];
      if (is_string($data[$keys[0]]))
      {
        $view->Custom = $data[$keys[0]];
      }
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
    $data = intval($data);
    if (empty($data) && $this->question->Required == 0)
    {
      return true;
    }
    foreach ($this->question->Answers as $answer)
    {
      if ($answer->AnswerId == $data)
      {
        if ($answer->Custom == 1)
        {
          $value = $this->getCustomValue($answer);
          if ($value === null || strlen($value) == 0)
          {
            return false;
          }
        }
        return true;
      }
    }

    return false;
  }

  /**
   * @param $data
   * @return array
   */
  public function BuildData($data)
  {
    $data = intval($data);
    //if ($this->Validate($data))
    //{
    foreach ($this->question->Answers as $answer)
    {
      if ($answer->AnswerId == $data)
      {
        if ($answer->Custom == 1)
        {
          $value = $this->getCustomValue($answer);
          if ($value !== null && strlen($value) > 0)
          {
            return array($data => $value);
          }
        }
        return array($data => true);
      }
    }
    //}
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
        if ($result!== null)
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