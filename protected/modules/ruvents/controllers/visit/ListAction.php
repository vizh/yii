<?php
namespace ruvents\controllers\visit;

use ruvents\components\Action;
use ruvents\components\Exception;
use ruvents\models\Visit;

/**
 * Class ListAction returns list of visit with according to filters
 */
class ListAction extends Action
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        $pageToken = \Yii::app()->getRequest()->getParam('PageToken', null);
        $createdOn = \Yii::app()->getRequest()->getParam('CreatedOn', null);
        if (!$this->validateDate($createdOn)) {
            throw new Exception(902, 'CreatedOn');
        }

        $offset = 0;
        if ($pageToken !== null) {
            $offset = $this->getController()->parsePageToken($pageToken);
        }

        $criteria = new \CDbCriteria([
            'order' => '"CreationTime" ASC',
            'limit' => \Yii::app()->params['RuventsMaxResults'],
            'offset' => $offset
        ]);

        if ($createdOn) {
            $criteria->addCondition('"CreationTime" >= :createdOn');
            $criteria->params[':createdOn'] = $createdOn;
        }

        $result = [
            'Visits' => Visit::model()
                ->byEventId($this->getEvent()->Id)
                ->findAll($criteria)
        ];

        if (count($result['Visits']) == \Yii::app()->params['RuventsMaxResults']) {
            $result['NextPageToken'] = $this->getController()->getPageToken($offset + \Yii::app()->params['RuventsMaxResults']);
        }

        $this->renderJson($result);
    }
}
