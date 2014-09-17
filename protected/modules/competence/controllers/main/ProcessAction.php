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
        $this->getController()->setPageTitle(strip_tags($this->getController()->getTest()->Title));
        $this->getController()->layout = "interview";

        $request = \Yii::app()->getRequest();
        $question = null;
        $currentQuestion = $this->getQuestion();
        $currentQuestion->Test = $this->getController()->getTest();
        $form = $currentQuestion->getForm();
        $form->setAttributes($request->getParam(get_class($form)), false);
        if ($request->getIsPostRequest() && $form->process()) {
            $prev = $request->getParam('prev');
            if (empty($prev)) {
                $question = $form->getNext();
            } else {
                $prevQuestion = $form->getPrev();
                $question = !empty($prevQuestion) ? $prevQuestion : $currentQuestion;
            }

            if ($question == null) {
                $this->finalizeInterview();
            }
            $question->Test = $this->getController()->getTest();

            $result = $question->getResult();
            if (!empty($result)) {
                $question->getForm()->setAttributes($result, false);
            }
        }

        $this->getController()->question = $question == null ? $currentQuestion : $question;

        $form = $this->getController()->question->getForm();
        $this->getController()->render($form->getViewPath(), ['form' => $form]);
    }

    /**
     * @throws \application\components\Exception
     * @return \competence\models\Question
     */
    private function getQuestion()
    {
        $request = \Yii::app()->getRequest();
        $id = $request->getParam('question');
        $question = \competence\models\Question::model()->findByPk($id);
        $test = $this->getController()->getTest();
        if ($question == null)
        {
            return $test->getFirstQuestion();
        }
        elseif ($question->TestId == $test->Id)
        {
            return $question;
        }
        else
            throw new \application\components\Exception('Вопрос с id: ' . $id . ' не найден в тесте ' . $test->Id);
    }

    private function finalizeInterview()
    {
        $test = $this->getController()->getTest();
        $test->saveResult();
        $this->getController()->redirect(\Yii::app()->createUrl('/competence/main/end', ['id' => $test->Id]));
    }
}