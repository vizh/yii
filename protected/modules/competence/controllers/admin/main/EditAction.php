<?php
namespace competence\controllers\admin\main;

use competence\models\form\NewQuestion;
use competence\models\Question;
use competence\models\QuestionType;
use competence\models\Test;

/**
 * Class EditAction shoes the page fir editing questions
 */
class EditAction extends \CAction
{
    /**
     * @param int $id Identifier of the test
     * @throws \CHttpException
     */
    public function run($id)
    {
        if (!$test = Test::model()->findByPk($id)) {
            throw new \CHttpException(404);
        }

        $form = new NewQuestion($test);

        $request = \Yii::app()->getRequest();
        $newQuestion = $request->getParam('newQuestion');
        if (!empty($newQuestion)) {
            $form->attributes = $request->getParam(get_class($form));
            if ($form->validate()) {
                $question = $form->createQuestion();
                $this->getController()->redirect(\Yii::app()->createUrl('/competence/admin/main/editQuestion', ['id' => $question->Id]));
            }
        }

        $questions = Question::model()->byTestId($test->Id)->findAll(['order' => '"t"."Sort"']);

        $saveChanges = $request->getParam('saveChanges');
        if (!empty($saveChanges)) {
            $this->parseQuestions($questions);
        }

        $this->getController()->render('edit', [
            'test' => $test,
            'questions' => $questions,
            'form' => $form,
            'types' => QuestionType::model()->findAll(['order' => '"t"."Id"'])
        ]);
    }

    /**
     * Parses questions
     * @param Question[] $questions
     */
    private function parseQuestions($questions)
    {
        $data = \Yii::app()->getRequest()->getParam('question');
        foreach ($questions as $question) {
            if (isset($data[$question->Id])) {
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
