<?php
namespace competence\controllers\main;

/**
 * Class ProcessAction
 * @package competence\controllers\main
 *
 * @method \MainController getController()
 */
class ProcessAction extends \CAction
{
  public function run($id)
  {
    $this->getController()->layout = "interview";

    /** @var \competence\models\Test $test */


    $request = \Yii::app()->getRequest();
    $question = $this->getQuestion();
    $question->setAttributes($request->getParam(get_class($question)), false);
    if ($request->getIsPostRequest() && $question->parse())
    {
      $prev = $request->getParam('prev');
      if (empty($prev))
      {
        $question = $question->getNext();
      }
      else
      {
        $prevQuestion = $question->getPrev();
        $question = !empty($prevQuestion) ? $prevQuestion : $question;
      }
      if (empty($question))
      {
        $this->finalizeInterview();
      }

      $fullData = $question->getFullData();
      if (isset($fullData[get_class($question)]))
      {
        $question->setAttributes($fullData[get_class($question)], false);
      }
    }

    $this->getController()->question = $question;
    $this->getController()->render($question->getViewPath(), ["question" => $question]);
  }

  /**
   * @return \competence\models\Question
   */
  private function getQuestion()
  {
    $request = \Yii::app()->getRequest();
    $questionName = $request->getParam('question');
    if (!empty($questionName) && class_exists($questionName))
    {
      return new $questionName($this->getController()->test);
    }
    else
    {
      return $this->getController()->test->getFirstQuestion();
    }
  }

  private function finalizeInterview()
  {
    $test = $this->getController()->test;
    $test->saveResult();
    $this->getController()->redirect(\Yii::app()->createUrl('/competence/main/end', ['id' => $test->Id]));
  }
}