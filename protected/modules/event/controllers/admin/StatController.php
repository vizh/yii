<?php
use application\components\utility\Paginator;
use event\models\Event;

class StatController extends \application\components\controllers\AdminMainController
{
    public function actionIndex()
    {
        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."StartYear" ASC, "t"."StartMonth" ASC, "t"."StartMonth" ASC';
        $criteria->with = ['Type', 'Attributes', 'LinkProfessionalInterests'];

        $searchQuery = \Yii::app()->getRequest()->getParam('Query', null);
        if (!empty($searchQuery)) {
            if (is_numeric($searchQuery)) {
                $criteria->addCondition('"t"."Id" = :Query');
                $criteria->params['Query'] = $searchQuery;
            } else {
                $criteria->addCondition('"t"."IdName" ILIKE :Query OR "t"."Title" ILIKE :Query');
                $criteria->params['Query'] = '%'.$searchQuery.'%';
            }
        }

        $paginator = new Paginator(Event::model()->count($criteria));
        $paginator->perPage = \Yii::app()->params['AdminEventPerPage'];
        $criteria->mergeWith($paginator->getCriteria());

        $events = Event::model()
            ->byFromDate(date('Y'), date('m'), date('d'))
            ->findAll($criteria);

        $data = [];
        foreach ($events as $i => $event) {
            $data[$i]['event'] = $event;

            $orders = \pay\models\Order::model()
                ->byDeleted(false)
                ->byEventId($event->Id)
                ->byPaid(true)
                ->byBankTransfer(true)
                ->findAll();
            $data[$i]['fin']['bank'] = array_reduce($orders, function ($carry, $order) {
                return $carry + $order->price;
            }, 0);

            $orders = \pay\models\Order::model()
                ->byDeleted(false)
                ->byEventId($event->Id)
                ->byPaid(true)
                ->byReceipt(true)
                ->findAll();
            $data[$i]['fin']['receipt'] = array_reduce($orders, function ($carry, $order) {
                return $carry + $order->price;
            }, 0);

            $orders = \pay\models\Order::model()
                ->byDeleted(false)
                ->byEventId($event->Id)
                ->byPaid(true)
                ->byJuridical(false)
                ->byReceipt(false)
                ->findAll();
            $data[$i]['fin']['online'] = array_reduce($orders, function ($carry, $order) {
                return $carry + $order->price;
            }, 0);
            $data[$i]['fin']['total'] = array_sum($data[$i]['fin']);

            $data[$i]['part']['paid'] = \Yii::app()->getDb()->createCommand()
                ->select('count(distinct "oi"."OwnerId") as "countUsers"')
                ->from('PayOrder o')
                ->leftJoin('PayOrderLinkOrderItem oloi', '"oloi"."OrderId" = "o"."Id"')
                ->leftJoin('PayOrderItem oi', '"oloi"."OrderItemId" = "oi"."Id"')
                ->where('"o"."EventId" = :EventId')
                ->andWhere('"o"."Paid" and not "o"."Deleted"')
                ->andWhere('"oi"."Paid" and not "oi"."Deleted"')
                ->bindValue(':EventId', $event->Id)
                ->queryScalar();

            $data[$i]['part']['promo'] = \Yii::app()->getDb()->createCommand()
                ->select('count(distinct "ca"."UserId") as "countUsers"')
                ->from('PayCouponActivation ca')
                ->leftJoin('PayCoupon c', '"ca"."CouponId" = "c"."Id"')
                ->where('"c"."EventId" = :EventId and ("c"."ManagerName" = :DiscountManagerName and "c"."Discount" = 100)')
                ->bindValue('EventId', $event->Id)
                ->bindValue('DiscountManagerName', 'Percent')
                ->queryScalar();

            $data[$i]['part']['total'] = \Yii::app()->getDb()->createCommand()
                ->select('count(distinct "oi"."OwnerId")')
                ->from('PayOrder o')
                ->leftJoin('PayOrderLinkOrderItem oloi', '"oloi"."OrderId" = "o"."Id"')
                ->leftJoin('PayOrderItem oi', '"oloi"."OrderItemId" = "oi"."Id"')
                ->leftJoin('EventParticipant ep', '"ep"."UserId" = "oi"."OwnerId"')
                ->where('"o"."EventId" = :EventId')
                ->andWhere('"o"."Paid" and not "o"."Deleted"')
                ->andWhere('"oi"."Paid" and not "oi"."Deleted"')
                ->andWhere('"ep"."RoleId" = :RoleVirtualParticipant')
                ->bindValue('EventId', $event->Id)
                ->bindValue('RoleVirtualParticipant', \event\models\Role::VIRTUAL_ROLE_ID)
                ->queryScalar();

            $data[$i]['part']['receipt'] = \Yii::app()->getDb()->createCommand()
                ->select('count(distinct "o"."Id")')
                ->from('PayOrder o')
                ->leftJoin('PayOrderLinkOrderItem oloi', '"oloi"."OrderId" = "o"."Id"')
                ->leftJoin('PayOrderItem oi', '"oloi"."OrderItemId" = "oi"."Id"')
                ->where('"o"."EventId" = :EventId')
                ->andWhere('not "o"."Deleted"')
                ->andWhere('not "oi"."Deleted"')
                ->bindValue('EventId', $event->Id)
                ->queryScalar();
        }

        $this->setPageTitle(\Yii::t('app', 'Список мероприятий'));

        $this->render('index', [
            'events' => $data,
            'paginator' => $paginator,
        ]);
    }
}
