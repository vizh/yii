<?php
namespace partner\controllers\order;

use application\modules\partner\models\search\Orders;

class IndexAction extends \partner\components\Action
{
    public function run()
    {
        $search = new Orders($this->getEvent());
        $this->getController()->render('index', [
            'search' => $search
        ]);
        exit;




        $event = \Yii::app()->partner->getEvent();

        $form = new \partner\models\forms\OrderSearch();
        $form->attributes = \Yii::app()->getRequest()->getParam(get_class($form));
        $criteria = $this->getCriteria($form);
        $count = \pay\models\Order::model()
            ->byEventId($event->Id)->count($criteria);


        $paginator = new \application\components\utility\Paginator($count);
        $paginator->perPage = \Yii::app()->params['PartnerOrderPerPage'];
        $criteria->mergeWith($paginator->getCriteria());
        $criteria->order = '"t"."CreationTime" DESC';

        $orders = \pay\models\Order::model()
            ->byEventId($event->Id)->findAll($criteria);

        $this->getController()->render('index',
            array(
                'form' => $form,
                'orders' => $orders,
                'paginator' => $paginator
            )
        );
    }
}