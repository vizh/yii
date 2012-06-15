<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alaris
 * Date: 09.03.12
 * Time: 22:02
 * To change this template use File | Settings | File Templates.
 */
class InputListQuestionType extends BaseQuestionType
{

  /**
   * @param mixed $data
   * @param mixed $error
   * @return View
   */
  public function RenderQuestion($data, $error = false)
  {
    $view = new View();
    $view->SetTemplate('inputlist', 'vote', 'questions', 'system');
    $view->Question = $this->question;
    $view->Criterions = $this->Criterions();
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

    if ($this->question->Required == 1 && sizeof($data) != sizeof($this->question->Answers))
    {
      return false;
    }

    foreach ($data as $key => $values)
    {
      if (!in_array($key, $answerIdList))
      {
        return false;
      }
      elseif ($this->question->Required == 1)
      {
        foreach ($values as $value)
        {
          if (trim($value) === '')
          {
            return false;
          }
        }
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
    return $data;

//    if ($this->Validate($data))
//    {
//      return $data;
//    }
//    return array();
  }

  /**
   * @return array
   */
  protected function Criterions()
  {
    $params = $this->GetParams();
    if (isset($params['Criterions']))
    {
      return $params['Criterions'];
    }
    else
    {
      return array('Значение');
    }
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
          $line[] = $this->forCsv(implode(', ', $data));
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
