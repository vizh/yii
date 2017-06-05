<?php

class StatController extends \partner\components\Controller
{

    public function actions()
    {
        return [
            'physicalpay' => '\partner\controllers\stat\PhysicalpayAction'
        ];
    }

    public function actionPay()
    {
        ini_set("memory_limit", "512M");

        $event = \event\models\Event::GetById(\Yii::app()->partner->getAccount()->EventId);

        $file = fopen($event->IdName.'-pay-'.date('Y-m-d').'.csv', 'w');

        $criteria = new CDbCriteria();
        $criteria->condition = 't.Paid = :Paid AND Product.EventId = :EventId';
        $criteria->params = [':EventId' => $event->EventId, ':Paid' => 1];
        $criteria->group = 't.OwnerId';

        $items = \pay\models\OrderItem::model()
            ->with(['Product' => ['select' => false]])
            ->findAll($criteria);

        $userIdList = [];

        foreach ($items as $item) {
            $userIdList[] = $item->OwnerId;
        }

        $criteria = new CDbCriteria();
        $criteria->addInCondition('t.UserId', $userIdList);

        /** @var $users User[] */
        $users = \user\models\User::model()->findAll($criteria);

        $products = \pay\models\Product::GetByEventId($event->EventId);

        foreach ($users as $user) {
            $criteria = new CDbCriteria();
            $criteria->condition = 't.OwnerId = :OwnerId AND t.Paid = :Paid AND Product.EventId = :EventId';
            $criteria->params = [':OwnerId' => $user->UserId, ':Paid' => 1, ':EventId' => $event->EventId];

            $result = [
                'RocId' => $user->RocId,
                'FIO' => iconv('utf-8', 'Windows-1251', $user->GetFullName()),
            ];

            foreach ($products as $product) {
                $result['PayType'.$product->ProductId] = '';
                $result['PayTotal'.$product->ProductId] = '';
                if ($product->EnableCoupon == 1) {
                    $result['Promo'.$product->ProductId] = '';
                    $result['Discount'.$product->ProductId] = '';
                }
            }

            /** @var $orderItems OrderItem[] */
            $orderItems = \pay\models\OrderItem::model()
                ->with(['Product' => ['select' => false]])
                ->findAll($criteria);
            foreach ($orderItems as $item) {
                $key = $item->ProductId;

                $result['PayType'.$key] = iconv('utf-8', 'Windows-1251', 'физ.');
                foreach ($item->Orders as $order) {
                    if (!empty($order->OrderJuridical) && $order->OrderJuridical->Paid == 1) {
                        $result['PayType'.$key] = iconv('utf-8', 'Windows-1251', 'юр.');
                        break;
                    }
                }

                $result['PayTotal'.$key] = $item->PriceDiscount();

                if (isset($result['Promo'.$key])) {
                    $couponActivated = $item->GetCouponActivated();
                    if (!empty($couponActivated) && $key != 'Range') {
                        $result['Promo'.$key] = $couponActivated->Coupon->Code;
                        $result['Discount'.$key] = $couponActivated->Coupon->getManager()->getDiscountString();
                    }
                }
            }

            fputcsv($file, $result);
        }

        fclose($file);
        echo 'Done!';
    }

}
