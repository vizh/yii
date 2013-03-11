<?php
class ListController extends \application\components\controllers\AdminMainController
{
  public function actionIndex()
  {
    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."Id" DESC';
    
    $searchQuery = \Yii::app()->request->getParam('Query', null);
    if (!empty($searchQuery))
    {
      if (is_int($searchQuery))
      {
       // $criteria->addCondition('"t"."Id" = :Query');
      }
      else 
      {
       // $criteria->addCondition();
      }
    }
   
    $eventCountAll = \event\models\Event::model()->count($criteria);
    $paginator = new \application\components\utility\Paginator($eventCountAll);
    $paginator->perPage = \Yii::app()->params['AdminEventPerPage'];
    $criteria->mergeWith($paginator->getCriteria());
    $events = \event\models\Event::model()->findAll($criteria);
    $this->render('index', array(
      'events' => $events, 
      'paginator' => $paginator,
    ));
  }
}
