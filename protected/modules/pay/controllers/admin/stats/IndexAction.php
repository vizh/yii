<?php
namespace pay\controllers\admin\stats;

use application\components\utility\Paginator;
use event\models\Event;
use pay\models\Order;

/**
 * Class IndexAction
 * @package pay\controllers\admin\failure
 */
class IndexAction extends \pay\components\Action
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."StartYear" asc, "t"."StartMonth" asc, "t"."StartMonth" asc';
        $criteria->with = [
            'PayAccount' => ['joinType' => 'inner join']
        ];

        $active_pager = new Paginator(Event::model()->byFromDate(date('Y'), date('m'), date('d'))->count($criteria), [], false, 'page_active');
        $active_pager->perPage = \Yii::app()->params['AdminEventPerPage'];

        $criteria->mergeWith($active_pager->getCriteria());

        $events = Event::model()
            ->byFromDate(date('Y'), date('m'), date('d'))
            ->findAll($criteria);

        $active_data = [];
        foreach ($events as $i => $event) {
            $active_data[$i]['index'] = $i+1;
            $active_data[$i]['event'] = $event;

            $orders = Order::model()
                ->byDeleted(false)
                ->byEventId($event->Id)
                ->byPaid(true)
                ->findAll();
            $active_data[$i]['total'] = 0;
            $active_data[$i]['types'] = [];
            foreach ($orders as $order) {
                if (!isset($active_data[$i]['types'][$order->Type])){
                    $active_data[$i]['types'][$order->Type] = 0;
                }
                $active_data[$i]['types'][$order->Type] += $order->Total;
                $active_data[$i]['total'] += $order->Total;
            }

            $active_data[$i]['participants'] = \Yii::app()->getDb()->createCommand()
                ->select('count(distinct "oi"."OwnerId")')
                ->from('PayOrder o')
                ->leftJoin('PayOrderLinkOrderItem oloi', '"oloi"."OrderId" = "o"."Id"')
                ->leftJoin('PayOrderItem oi', '"oloi"."OrderItemId" = "oi"."Id"')
                ->leftJoin('EventParticipant ep', '"ep"."UserId" = "oi"."OwnerId"')
                ->where('"o"."EventId" = :EventId')
                ->andWhere('"o"."Paid" and not "o"."Deleted"')
                ->andWhere('"oi"."Paid" and not "oi"."Deleted"')
                ->andWhere('"ep"."RoleId" <> :RoleVirtualParticipant')
                ->bindValue('EventId', $event->Id)
                ->bindValue('RoleVirtualParticipant', \event\models\Role::VIRTUAL_ROLE_ID)
                ->queryScalar();
        }


        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."StartYear" desc, "t"."StartMonth" desc, "t"."StartMonth" desc';

        $past_pager = new Paginator(Event::model()->byToDate(date('Y'), date('m'), date('d'))->count($criteria), [], false, 'page_past');
        $past_pager->perPage = \Yii::app()->params['AdminEventPerPage'];
        $criteria->mergeWith($past_pager->getCriteria());

        $events = Event::model()
            ->byToDate(date('Y'), date('m'), date('d'))
            ->findAll($criteria);

        $past_data = [];
        foreach ($events as $i => $event) {
            $past_data[$i]['event'] = $event;

            $orders = Order::model()
                ->byDeleted(false)
                ->byEventId($event->Id)
                ->byPaid(true)
                ->findAll();
            $past_data[$i]['total'] = 0;
            $past_data[$i]['types'] = [];
            foreach ($orders as $order) {
                if (!isset($past_data[$i]['types'][$order->Type])){
                    $past_data[$i]['types'][$order->Type] = 0;
                }
                $past_data[$i]['types'][$order->Type] += $order->Total;
                $past_data[$i]['total'] += $order->Total;
            }

            $past_data[$i]['participants'] = \Yii::app()->getDb()->createCommand()
                ->select('count(distinct "oi"."OwnerId")')
                ->from('PayOrder o')
                ->leftJoin('PayOrderLinkOrderItem oloi', '"oloi"."OrderId" = "o"."Id"')
                ->leftJoin('PayOrderItem oi', '"oloi"."OrderItemId" = "oi"."Id"')
                ->leftJoin('EventParticipant ep', '"ep"."UserId" = "oi"."OwnerId"')
                ->where('"o"."EventId" = :EventId')
                ->andWhere('"o"."Paid" and not "o"."Deleted"')
                ->andWhere('"oi"."Paid" and not "oi"."Deleted"')
                ->andWhere('"ep"."RoleId" <> :RoleVirtualParticipant')
                ->bindValue('EventId', $event->Id)
                ->bindValue('RoleVirtualParticipant', \event\models\Role::VIRTUAL_ROLE_ID)
                ->queryScalar();
        }

        $this->getController()->render('index', [
            'active_data' => $active_data,
            'active_pager' => $active_pager,
            'past_data' => $past_data,
            'past_pager' => $past_pager,
        ]);
    }
}
