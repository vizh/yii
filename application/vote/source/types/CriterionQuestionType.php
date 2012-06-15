<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alaris
 * Date: 03.03.12
 * Time: 9:36
 * To change this template use File | Settings | File Templates.
 */
class CriterionQuestionType extends BaseQuestionType
{

  /**
   * @param mixed $data
   * @param mixed $error
   * @return View
   */
  public function RenderQuestion($data, $error = false)
  {
    $view = new View();
    $view->SetTemplate('criterion', 'vote', 'questions', 'system');
    $view->Question = $this->question;
    $view->MinRate = $this->MinRate();
    $view->MaxRate = $this->MaxRate();
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

    foreach ($data as $key => $value)
    {
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

  /**
   * @return int
   */
  protected function MinRate()
  {
    $params = $this->GetParams();
    if (isset($params['MinRate']))
    {
      return $params['MinRate'];
    }
    else
    {
      return 1;
    }
  }

  /**
   * @return int
   */
  protected function MaxRate()
  {
    $params = $this->GetParams();
    if (isset($params['MaxRate']))
    {
      return $params['MaxRate'];
    }
    else
    {
      return 5;
    }
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
      return array('Оценка');
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
        if ($result !== null)
        {
          if ($result->Custom != null)
          {
            $line[] = $this->forCsv(base64_decode($result->Custom));
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