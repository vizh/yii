<?php

use application\components\console\BaseConsoleCommand;
use mail\components\mailers\SESMailer;
use pay\models\Order;
use pay\models\OrderItem;
use pay\models\OrderLinkOrderItem;
use pay\models\OrderType;

class PayCommand extends BaseConsoleCommand
{
    public function actionJuridicalOrderNotPaidNotify()
    {
        $date = date('Y-m-d', time() - (4 * 24 * 60 * 60));
        $criteria = new \CDbCriteria();
        $criteria->addCondition('"t"."CreationTime" >= :MinTime AND "t"."CreationTime" <= :MaxTime');
        $criteria->params['MinTime'] = $date . ' 00:00:00';
        $criteria->params['MaxTime'] = $date . ' 23:59:59';

        $orders = Order::model()->byBankTransfer(true)->byDeleted(false)->byPaid(false)->findAll($criteria);
        $mailer = new SESMailer();
        foreach ($orders as $order) {
            $language = $order->Payer->Language != null ? $order->Payer->Language : 'ru';
            Yii::app()->setLanguage($language);
            $class = \Yii::getExistClass('\pay\components\handlers\orderjuridical\notify\notpaid', ucfirst($order->Event->IdName), 'Base');
            $mail = new $class($mailer, $order);
            $mail->send();
        }

        return 0;
    }

    public function actionClearPhysicalBook()
    {
        $orderItems = OrderItem::model()
            ->byEventId(\Yii::app()->params['AdminBookingEventId'])
            ->byPaid(false)
            ->byBooked(false)
            ->byDeleted(false)
            ->findAll();

        foreach ($orderItems as $item) {
            $item->delete();
        }

        return 0;
    }

    /**
     * Удаление забронированных номеров для РИФ, если это физический счет - заказ удаляется, если счет юр. - удаляется счет или заказ из счета
     * @throws CDbException
     */
    public function actionClearRifBook()
    {
        $orderItems = OrderItem::model()
            ->byEventId(\Yii::app()->params['AdminBookingEventId'])
            ->byPaid(false)
            ->byBooked(false)
            ->byDeleted(false)
            ->findAll();

        foreach ($orderItems as $orderItem) {
            $orderLinks = $orderItem->OrderLinks(['with' => ['Order']]);
            /** @var OrderLinkOrderItem $orderLink */
            foreach ($orderLinks as $orderLink) {
                $order = $orderLink->Order;
                if (OrderType::getIsLong($order->Type) && !$order->Deleted) {
                    $count = 0;
                    foreach ($order->ItemLinks as $itemLink) {
                        if ($itemLink->OrderItem->Id != $orderItem->Id && !$itemLink->OrderItem->Paid && !$itemLink->OrderItem->Deleted) {
                            $count++;
                        }
                    }

                    if ($count === 0) {
                        $order->delete();
                    } else {
                        $orderLink->delete();
                    }
                }
            }

            $orderItem->deleteHard();
        }
    }
}
