<?php
namespace competence\controllers\admin\main;

class EditQuestionAction extends \CAction
{
    public function run($id)
    {
        $question = \competence\models\Question::model()->findByPk($id);
        if ($question === null) {
            throw new \CHttpException(404);
        }
        $test = \competence\models\Test::model()->findByPk($question->TestId);
        if ($test === null) {
            throw new \CHttpException(404);
        }

        $question->Test = $test;
        $request = \Yii::app()->getRequest();
        if ($request->getIsPostRequest()) {
            $question->getForm()->processAdminPanel();
            if (!$question->hasErrors()) {
                $question->save();
            }
        }

        $this->getController()->render('editQuestion', ['question' => $question, 'test' => $test]);
    }
}

