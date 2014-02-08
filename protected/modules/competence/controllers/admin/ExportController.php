<?php

use \competence\models\tests\mailru2013;

class ExportController extends \application\components\controllers\AdminMainController
{
  /** @var  \competence\models\Test */
  private $test;

  public function actionIndex($testId)
  {
    $this->test = \competence\models\Test::model()->findByPk($testId);
    if ($this->test === null)
      throw new CHttpException(404);

    if (Yii::app()->getRequest()->getIsPostRequest())
    {
      ini_set("memory_limit", "512M");
      $fp = fopen(Yii::getPathOfAlias('competence.data') . '/result'.$this->test->Id.'.csv',"w");

      $row = [];
      $row[] = 'ID';
      $row[] = 'Статус';
      foreach ($this->getQuestions() as $question)
      {
        $row[] = $question->Code . ': ' . $question->Title;
        $row[] = $question->Code . ': ' . $question->Title . ' - other';
        $row[] = $question->Code . ': ' . $question->Title . ' - time';
      }

      fputcsv($fp, $row, ';');

      /** @var \competence\models\Result[] $results */
      $results = \competence\models\Result::model()->byTestId($this->test->Id)->findAll();

      foreach ($results as $result)
      {
        $data = unserialize(base64_decode($result->Data));
        $row = [];
        $row[] = $result->Id;
        $row[] = $result->Finished ? 'Завершена' : 'Не завершена';
        foreach ($this->getQuestions() as $question)
        {
          if (isset($data[$question->Code]))
          {
            $qData = $data[$question->Code];

            $row[] = json_encode($qData['value'], JSON_UNESCAPED_UNICODE);
            $row[] = json_encode(isset($qData['other']) ? $qData['other'] : '', JSON_UNESCAPED_UNICODE);
            $row[] = $qData['DeltaTime'];
          }
          else
          {
            $row[] = '';
            $row[] = '';
            $row[] = '';
          }
        }
        fputcsv($fp, $row, ';');
      }

      fclose($fp);

      echo 'Done';
      exit;
    }

    $countFinished = \competence\models\Result::model()->byTestId($this->test->Id)->count('"Finished"');
    $countNotFinished = \competence\models\Result::model()->byTestId($this->test->Id)->count('NOT "Finished"');

    $this->render('index', ['test' => $this->test, 'countFinished' => $countFinished, 'countNotFinished' => $countNotFinished]);
  }

  private $questions = null;

  private function getQuestions()
  {
    if ($this->questions === null)
    {
      $this->questions = \competence\models\Question::model()->byTestId($this->test->Id)
        ->findAll(['order' => '"Sort"']);
      foreach ($this->questions as $question)
        $question->setTest($this->test);
    }
    return $this->questions;
  }
}