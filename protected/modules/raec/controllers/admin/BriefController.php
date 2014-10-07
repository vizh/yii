<?php
use application\components\controllers\AdminMainController;
use application\components\utility\Paginator;
use raec\models\Brief;

class BriefController extends AdminMainController
{
    public function actionIndex()
    {
        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."CreationTime" DESC';
        $paginator = new Paginator(Brief::model()->count($criteria));
        $criteria->mergeWith($paginator->getCriteria());

        $briefs = Brief::model()->findAll($criteria);
        $this->setPageTitle(\Yii::t('app', 'Анкеты членов НП “РАЭК”'));
        $this->render('index', ['briefs' => $briefs, 'paginator' => $paginator]);
    }

    public function actionView($briefId)
    {
        $brief = Brief::model()->findByPk($briefId);
        if ($brief == null) {
            throw new CHttpException(404);
        }
        $this->setPageTitle(\Yii::t('app', 'Анкета члена НП “РАЭК”'));
        $this->render('view', ['brief' => $brief]);
    }
} 