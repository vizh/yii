<?php
namespace partner\controllers\coupon;

use partner\components\Action;
use pay\models\Coupon;

class StatisticsAction extends Action
{
    public function run($id)
    {
        $coupon = Coupon::model()->byEventId($this->getEvent()->Id)->with(['Activations'])->findByPk($id);
        if ($coupon === null) {
            throw new \CHttpException(404);
        }

        $stat = new \stdClass();
        $stat->count = 0;
        $stat->total = 0;

        foreach ($coupon->Activations as $activation) {
            foreach ($activation->OrderItemLinks as $link) {
                if ($link->OrderItem->Paid) {
                    $stat->count++;
                    $stat->total += $link->OrderItem->getPriceDiscount();
                }
            }
        }

        $this->getController()->render('statistics', [
            'coupon' => $coupon,
            'stat' => $stat,
        ]);
    }
} 