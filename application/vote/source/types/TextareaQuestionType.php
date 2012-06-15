<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 16.05.12
 * Time: 17:11
 * To change this template use File | Settings | File Templates.
 */
class TextareaQuestionType extends InputQuestionType
{
  /**
   * @param mixed $data
   * @param mixed $error
   * @return View
   */
  public function RenderQuestion($data, $error = false)
  {
    $view = new View();
    $view->SetTemplate('textarea', 'vote', 'questions', 'system');
    $view->Question = $this->question;
    if (! empty($data))
    {
      $view->Values = $data;
    }
    $view->Error = $error;
    return $view;
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