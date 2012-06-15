<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 06.03.12
 * Time: 16:57
 * To change this template use File | Settings | File Templates.
 */
class RankQuestionType extends BaseQuestionType
{
  /**
   * @param mixed $data
   * @param mixed $error
   * @return View
   */
  public function RenderQuestion($data, $error = false)
  {
    $view = new View();
    $view->SetTemplate('rank', 'vote', 'questions', 'system');
    $view->Question = $this->question;
    $view->Values = !empty($data) ? $data : array();
    $view->Error = $error;
    return $view;
  }

  /**
   * @param mixed $data
   * @return bool
   */
  public function Validate($data)
  {
    if (sizeof($data) != sizeof($this->question->Answers))
    {
      return false;
    }

    $keys = array_keys($data);
    foreach ($this->question->Answers as $answer)
    {
      if (! in_array($answer->AnswerId, $keys))
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
    return $data;
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
      $results = $answer->GetResults($resultIdList);
      $line = array();
      $line[] = $this->forCsv($answer->Answer);
      $line[] = sizeof($results);

      foreach ($localResultList as $result)
      {
        if ($result !== null && $result->Custom != null)
        {
          $line[] = $this->forCsv(base64_decode($result->Custom));
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
