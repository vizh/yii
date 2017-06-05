<?php
namespace partner\controllers\user;

use application\modules\partner\models\search\Competence;
use competence\models\Test;
use partner\components\Action;

/**
 * Опрос участников
 */
class CompetenceAction extends Action
{
    public function run()
    {
        $test = Test::model()->byEventId($this->getEvent()->Id)->find();
        if ($test === null) {
            throw new \CHttpException(404);
        }

        $search = new Competence($this->getEvent());
        $this->getController()->render('competence', [
            'search' => $search,
            'event' => $this->getEvent(),
            'test' => $test
        ]);
    }
}