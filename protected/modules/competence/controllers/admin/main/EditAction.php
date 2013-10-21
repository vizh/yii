<?php
namespace competence\controllers\admin\main;

class EditAction extends \CAction
{
  public function run($id)
  {
    $test = \competence\models\Test::model()->findByPk($id);
    if ($test === null)
      throw new \CHttpException(404);

    $form = new \competence\models\form\NewQuestion($test);

    $request = \Yii::app()->getRequest();
    $newQuestion = $request->getParam('newQuestion');
    if (!empty($newQuestion))
    {
      $form->attributes = $request->getParam(get_class($form));
      if ($form->validate())
      {
        $question = $form->createQuestion();
        $this->getController()->redirect(\Yii::app()->createUrl('/competence/admin/main/editQuestion', ['id' => $question->Id]));
      }
    }

    $questions = \competence\models\Question::model()->byTestId($test->Id)->findAll(['order' => '"t"."Sort"']);

    $saveChanges = $request->getParam('saveChanges');
    if (!empty($saveChanges))
    {
      $this->parseQuestions($questions);
    }

    $this->getController()->render('edit', [
      'test' => $test,
      'questions' => $questions,
      'form' => $form
    ]);
  }

  /**
   * @param \competence\models\Question[] $questions
   */
  private function parseQuestions($questions)
  {
    $data = \Yii::app()->getRequest()->getParam('question');
    foreach ($questions as $question)
    {
      if (isset($data[$question->Id]))
      {
        $question->PrevQuestionId = intval($data[$question->Id]['PrevId']) != 0 ? $data[$question->Id]['PrevId'] : null;
        $question->NextQuestionId = intval($data[$question->Id]['NextId']) != 0 ? $data[$question->Id]['NextId'] : null;
        $question->First = isset($data[$question->Id]['First']);
        $question->Last = isset($data[$question->Id]['Last']);
        $question->Sort = $data[$question->Id]['Sort'];
        $question->save();
      }
    }
  }
}