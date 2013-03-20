<?php
class DefaultController extends \application\components\controllers\PublicMainController
{
	public function actionIndex()
	{
    $this->setPageTitle('RUNET-ID');

    \Yii::app()->getClientScript()->registerPackage('highcharts');


    $date = getdate();
    $criteria = new CDbCriteria();
    $criteria->order = '"t"."ShowOnMain" DESC, "t"."StartYear", "t"."StartMonth", "t"."StartDay", "t"."EndYear", "t"."EndMonth", "t"."EndDay"';
    $criteria->limit = 3;
    $events = \event\models\Event::model()
        ->byVisible(true)
        ->byFromDate($date['year'], $date['mon'], $date['mday'])
        ->findAll($criteria);

    
    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."Id" DESC';
    $criteria->limit = 4;
    $jobs = \job\models\Job::model()->findAll($criteria);
    
    $this->render('index', array(
      'events' => $events,
      'jobs' => $jobs
    ));
	}
}