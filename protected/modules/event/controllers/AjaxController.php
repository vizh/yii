<?php
use event\models\Event;
use event\models\Participant;

class AjaxController extends \application\components\controllers\PublicMainController
{
    public function actions()
    {
        return [
            'userregister' => '\event\controllers\ajax\UserRegisterAction'
        ];
    }

    /**
     * Поиск события по заданному критерию
     *
     * @param type $term
     * @return string
     */

    public function actionSearch($term)
    {
        $results = [];
        $criteria = new CDbCriteria();
        $criteria->limit = 10;
        $criteria->order = '"t"."Id" DESC';

        if (is_numeric($term)) {
            $criteria->addCondition('"t"."Id" = :Id');
            $criteria->params['Id'] = $term;
        } else {
            $criteria->addCondition('"t"."IdName" ILIKE :Term OR "t"."Title" ILIKE :Term');
            $criteria->params['Term'] = '%'.$term.'%';
        }
        $events = Event::model()->byDeleted(false)->findAll($criteria);
        foreach ($events as $event) {
            $item = new stdClass();
            $item->Id = $item->value = $event->Id;
            $item->Title = $item->label = $event->Title;
            $results[] = $item;
        }
        echo json_encode($results);
    }

    /**
     * Поиск события, в котором есть хотя бы 1 участник
     *
     * @param type $term
     * @return string
     */

    public function actionSearchNotNull($term)
    {
        $results = [];
        $criteria = new CDbCriteria();
        $criteria->limit = 10;
        $criteria->order = '"t"."Id" DESC';
        if (is_numeric($term)) {
            $criteria->addCondition('"t"."Id" = :Id');
            $criteria->params['Id'] = $term;
        } else {
            $criteria->addCondition('"t"."IdName" ILIKE :Term OR "t"."Title" ILIKE :Term');
            $criteria->params['Term'] = '%'.$term.'%';
        }

        $events = Event::model()->byDeleted(false)->findAll($criteria);
        foreach ($events as $event) {
            $pModel = new Participant();
            $participants = $pModel->byEventId($event->Id)->count();
            if ($participants) {
                $item = new stdClass();
                $item->Id = $item->value = $event->Id;
                $item->Title = $item->label = $event->Title;
                $results[] = $item;
            }
        }
        echo json_encode($results);
    }
}
