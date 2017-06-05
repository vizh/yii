<?php

class Export3Controller extends \application\components\controllers\PublicMainController
{
    private $test;

    public function actionIndex()
    {
        ini_set("memory_limit", "512M");
        $fp = fopen(Yii::getPathOfAlias('competence.data').'/result3.csv', "w");

        $this->test = \competence\models\Test::model()->findByPk(3);
        $questions = $this->getQuestions();

        $row = [];
        foreach ($questions as $question) {
            $row[] = $question->Title.' - value';
            $row[] = $question->Title.' - other';
            $row[] = $question->Title.' - time';
        }
        fputcsv($fp, $row, ';');

        $results = \competence\models\Result::model()->byTestId(3)->byFinished(true)->findAll();
        foreach ($results as $result) {
            $data = unserialize(base64_decode($result->Data));
            $row = [];
            foreach ($questions as $class => $question) {
                $name = substr(strrchr($class, "\\"), 1);
                if (isset($data[$name])) {
                    $qData = $data[$name];
                    $row[] = json_encode($qData['value'], JSON_UNESCAPED_UNICODE);
                    $row[] = json_encode(isset($qData['other']) ? $qData['other'] : '', JSON_UNESCAPED_UNICODE);
                    $row[] = $qData['DeltaTime'];
                } else {
                    $row[] = '';
                    $row[] = '';
                    $row[] = '';
                }
            }
            fputcsv($fp, $row, ';');
        }

        fclose($fp);
        echo 'Done';
    }

    /**
     * @param \competence\models\Test $test
     *
     * @return string[]
     */
    public function getQuestions()
    {
        $names = [];
        $question = $this->test->getFirstQuestion();
        while (true) {
            $names[get_class($question->getForm())] = $question;
            $question = $question->getForm()->getNext();
            if ($question == null) {
                break;
            }
            $question->setTest($this->test);
        }
        return $names;
    }
}