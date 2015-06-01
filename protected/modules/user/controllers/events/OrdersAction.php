<?php
namespace user\controllers\events;

use event\models\Participant;
use pay\components\Exception;
use pay\models\Order;
use pay\models\OrderItem;

class OrdersAction extends \CAction
{
    public function run()
    {
        $user = \Yii::app()->user->getCurrentUser();
        $orderItems = OrderItem::model()->byPayerId($user->Id)->byDeleted(false)->findAll(array('order' => '"t"."CreationTime" ASC'));
        $pastOrders = $waitOrders = [];
        $ids = [];

        foreach ($orderItems as $item) :
            if(!isset($item->Product->Id))
                continue;

            if (in_array($item->Product->Id, $ids))
                continue;
            $ids[] = $item->Product->Id;

            strlen($item->Product->Event->StartMonth) == 1 ? $item->Product->Event->StartMonth = '0' . $item->Product->Event->StartMonth : '';
            strlen($item->Product->Event->StartDay) == 1 ? $item->Product->Event->StartDay = '0' . $item->Product->Event->StartDay : '';
            $eventDate = $item->Product->Event->StartYear . $item->Product->Event->StartMonth . $item->Product->Event->StartDay;
            $curDate = date('Ymd');
            if ($item->Paid) :
                try {
                    if ($item->getPriceDiscount() == 0)
                        continue;
                    $pastOrders[$item->Product->Id]['Item'] = $item;
                    $pastOrders[$item->Product->Id]['EventDate'] = $eventDate;
                    $pastOrders[$item->Product->Id]['Participant'] = Participant::model()->byUserId($user->Id)
                        ->byEventId($item->Product->Event->Id)
                        ->find();

                    $pastOrders[$item->Product->Id]['Juridical'] = Order::model()->byPayerId($user->Id)
                        ->byJuridical(true)
                        ->byEventId($item->Product->Event->Id)
                        ->byPaid(false)
                        ->byDeleted(false)
                        ->findAll();
                } catch (Exception $a) {
                }
            else:
                if ($eventDate > $curDate) :
                    try {
                        if ($item->getPriceDiscount() == 0)
                            continue;
                        $waitOrders[$item->Product->Id]['Item'] = $item;
                        $waitOrders[$item->Product->Id]['EventDate'] = $eventDate;
                        $waitOrders[$item->Product->Id]['Participant'] = Participant::model()->byUserId($user->Id)
                            ->byEventId($item->Product->Event->Id)
                            ->find();

                        $waitOrders[$item->Product->Id]['Juridical'] = Order::model()->byPayerId($user->Id)
                            ->byJuridical(true)
                            ->byEventId($item->Product->Event->Id)
                            ->byPaid(false)
                            ->byDeleted(false)
                            ->findAll();
                    } catch (Exception $a) {
                    }
                endif;
            endif;
        endforeach;
        $this->getController()->render('orders',
            array(
                'pastOrders' => $this->sortByEvent($pastOrders),
                'waitOrders' => $this->sortByEvent($waitOrders)
            )
        );
    }

    /**
     * Сортировка заказов по событию
     * @param $array
     * @return array
     */
    public function sortByEvent($array)
    {
        $result = [];
        foreach ($array as $item) {
            $result[$item['Item']->Product->Event->Id][] = $item;
        }
        return array_reverse($result);
    }
}