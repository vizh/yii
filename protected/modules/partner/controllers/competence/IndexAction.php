<?php
namespace partner\controllers\competence;

class IndexAction extends \partner\components\Action
{
    public function run()
    {
        $tests = \competence\models\Test::model()->byEventId($this->getEvent()->Id)->findAll();
        if (empty($tests)) {
            throw new \CHttpException(404);
        }

        $this->getController()->setPageTitle(\Yii::t('app', 'Компетенции'));
        $this->getController()->render('index', ['tests' => $tests]);
    }
}
