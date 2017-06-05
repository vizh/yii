<?php

class CompetenceController extends \partner\components\Controller
{
    public function actions()
    {
        return [
            'index' => '\partner\controllers\competence\IndexAction',
            'results' => '\partner\controllers\competence\ResultsAction',
            'answers' => '\partner\controllers\competence\AnswersAction'
        ];
    }
}
