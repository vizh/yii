<?php
namespace partner\controllers\competence;

class ResultsAction extends \partner\components\Action
{
    public function run($testId)
    {
        $test = \competence\models\Test::model()->byEventId($this->getEvent()->Id)->findByPk($testId);
        if ($test == null) {
            throw new \CHttpException(404);
        }

        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."UpdateTime" DESC';
        $criteria->with = ['User.Settings'];
        $count = \competence\models\Result::model()->byTestId($test->Id)->count();
        $paginator = new \application\components\utility\Paginator($count);
        $paginator->perPage = \Yii::app()->params['PartnerCompetenceResultPerPage'];
        $criteria->mergeWith($paginator->getCriteria());
        $results = \competence\models\Result::model()->byTestId($test->Id)->findAll($criteria);

        $this->getController()->setPageTitle(\Yii::t('app', 'Результаты теста: {test}', ['{test}' => $test->Title]));
        $this->getController()->render('results', ['test' => $test, 'results' => $results, 'paginator' => $paginator]);
    }
}
