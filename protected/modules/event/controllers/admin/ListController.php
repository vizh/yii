<?php
use application\components\utility\Paginator;
use \event\models\Event;

class ListController extends \application\components\controllers\AdminMainController
{
    public function actionIndex()
    {
        $this->processAction();

        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."Id" DESC';
        $criteria->with  = ['Type','Attributes','LinkProfessionalInterests'];

        $searchQuery = \Yii::app()->getRequest()->getParam('Query', null);
        if (!empty($searchQuery))
        {
            if (is_numeric($searchQuery))
            {
                $criteria->addCondition('"t"."Id" = :Query');
                $criteria->params['Query'] = $searchQuery;
            }
            else
            {
                $criteria->addCondition('"t"."IdName" ILIKE :Query OR "t"."Title" ILIKE :Query');
                $criteria->params['Query'] = '%'.$searchQuery.'%';
            }
        }

        $approved = \Yii::app()->request->getParam('Approved', null);
        if ($approved !== null)
        {
            $criteria->addCondition('"t"."External" AND "t"."Approved" = :Approved');
            $criteria->params['Approved'] = $approved;
        }

        $paginator = new Paginator(Event::model()->count($criteria));
        $paginator->perPage = \Yii::app()->params['AdminEventPerPage'];
        $criteria->mergeWith($paginator->getCriteria());
        $events = Event::model()->findAll($criteria);
        $this->render('index', array(
            'events' => $events,
            'paginator' => $paginator,
        ));
    }

    private function processAction()
    {
        $request = \Yii::app()->getRequest();
        $action = $request->getParam('Action');
        if ($action == null)
            return;

        $event = \event\models\Event::model()->findByPk($request->getParam('EventId'));
        if ($event == null)
            return;

        $backUrl = $request->getParam('BackUrl');
        if ($backUrl == null)
            return;

        switch ($action)
        {
            case 'Delete':
                if ($event->getCanBeRemoved())
                {
                    $event->Deleted = true;
                    $event->DeletionTime = date('Y-m-d H:i:s');
                    $event->save();
                }
        }

        $this->redirect($backUrl);
    }
}
