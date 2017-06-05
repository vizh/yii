<?php
namespace partner\controllers\special\rif13;

class ClearbookAction extends \partner\components\Action
{
    public function run()
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('"t"."Booked" IS NOT NULL');
        $criteria->addCondition('"t"."Booked" < :Booked');
        $criteria->params['Booked'] = '2013-04-15 00:00:00';
        $criteria->order = '"Product"."Id" ASC';

        /** @var $orderItems \pay\models\OrderItem[] */
        $orderItems = \pay\models\OrderItem::model()
            ->byEventId(\Yii::app()->partner->getEvent()->Id)
            ->byPaid(false)->byDeleted(false)
            ->findAll($criteria);

        foreach ($orderItems as $item) {
            echo $item->ProductId.' Въезд: '.$item->getItemAttribute('DateIn').' Выезд: '.$item->getItemAttribute('DateOut').'<br>';
            //$item->deleteHard();
        }

        echo 'done: '.sizeof($orderItems);
    }
}
