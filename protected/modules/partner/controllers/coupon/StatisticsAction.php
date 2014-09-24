<?php
namespace partner\controllers\coupon;

use event\models\Event;
use partner\components\Action;
use pay\models\Coupon;

class StatisticsAction extends Action
{
    public function run($eventIdName, $code, $hash)
    {
        $this->getController()->setPageTitle('Статистика по промо-коду');
        $this->getController()->showMenu = false;

        $event = Event::model()->byIdName($eventIdName)->find();
        if ($event === null)
            throw new \CHttpException(404);
        $coupon = Coupon::model()->byCode($code)->byEventId($event->Id)->find();
        if ($coupon === null)
            throw new \CHttpException(404);
        if ($coupon->getHash() !== $hash)
            throw new \CHttpException(404);


        $paidCount = 0;
        $paidTotal = 0;
        foreach ($coupon->Activations as $activation) {
            foreach ($activation->OrderItemLinks as $link) {
                if ($link->OrderItem->Paid) {
                    $paidCount++;
                    $paidTotal += $link->OrderItem->getPriceDiscount();
                }
            }
        }


        $this->getController()->render('statistics', [
            'coupon' => $coupon,
            'paidCount' => $paidCount,
            'paidTotal' => $paidTotal
        ]);
    }
} 