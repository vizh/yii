<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 11.03.12
 * Time: 11:40
 * To change this template use File | Settings | File Templates.
 */
class InfoQuestionType extends BaseQuestionType
{

  /**
   * @param mixed $data
   * @param mixed $error
   * @return View
   */
  public function RenderQuestion($data, $error = false)
  {
    $view = new View();
    $view->SetTemplate('info', 'vote', 'questions', 'system');
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
    return true;
  }

  /**
   * @param $data
   * @return array
   */
  public function BuildData($data)
  {
    return array();
  }

  public function ResultCsv($file, $resultIdList)
  {
    // TODO: Implement ResultCsv() method.
  }
}
