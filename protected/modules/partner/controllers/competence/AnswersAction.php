<?php
namespace partner\controllers\competence;

class AnswersAction extends \partner\components\Action
{
    private $test;

    public function run($testId, $resultId, $backPage)
    {
        $this->test = \competence\models\Test::model()->byEventId($this->getEvent()->Id)->findByPk($testId);
        if ($this->test == null) {
            throw new \CHttpException(404);
        }

        $result = \competence\models\Result::model()->byTestId($testId)->findByPk($resultId);
        if ($result == null) {
            throw new \CHttpException(404);
        }

        $resultData = $result->getResultByData();
        $answers = [];
        foreach ($this->getQuestions() as $key => $question) {
            $answer = new \stdClass();
            $answer->Question = $question;
            $name = substr($key, strrpos($key, '\\') + 1);
            if (!isset($resultData[$name])) {
                continue;
            }

            $data = $resultData[$name];
            switch ($question->Type->Class) {
                case 'competence\models\form\Single':
                    $answer->Answer = $this->getAnswerValue($question, $data['value'], $data['other']);
                    break;

                case 'competence\models\form\Multiple':
                    $answer->Answer = [];
                    foreach ($data['value'] as $value) {
                        $answer->Answer[] = $this->getAnswerValue($question, $value, $data['other']);
                    }
                    break;

                default:
                    $answer->Answer = $data['value'];
                    break;
            }
            $answers[] = $answer;
        }

        $this->getController()->setPageTitle(\Yii::t('app', 'Ответы пользователя в тесте: {test}', ['{test}' => $this->test->Title]));
        $this->getController()->render('answers', [
            'test' => $this->test,
            'result' => $result,
            'answers' => $answers,
            'backPage' => (int)$backPage
        ]);
    }

    private function getQuestions()
    {
        $questions = [];
        $question = $this->test->getFirstQuestion();
        while (true) {
            $questions[get_class($question->getForm())] = $question;
            $question = $question->getForm()->getNext();
            if ($question == null) {
                break;
            }
            $question->setTest($this->test);
        }
        return $questions;
    }

    /**
     *
     * @param \competence\models\Question $question
     * @param int $userValue
     * @return string
     */
    private function getAnswerValue($question, $userValue, $otherValue = null)
    {
        foreach ($question->getFormData()['Values'] as $value) {
            if ($value->key == $userValue) {
                return $value->isOther ? '<strong>Другое:</strong> '.$otherValue : $value->title;
            }
        }
    }
}
