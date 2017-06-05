<?php

use event\models\Approved;
use event\models\Event;
use main\components\admin\Statistics;
use pay\models\Order;
use user\models\User;

class DefaultController extends \application\components\controllers\AdminMainController
{

    public function actionIndex()
    {
        $waitEvents = Event::model()->byExternal(true)->byApproved(Approved::NONE)->byDeleted(false)->orderBy(['"t"."CreationTime"' => SORT_DESC])
            ->limit(10)->findAll();

        $publishedEvents = Event::model()->byVisible(true)->orderBy(['"t"."CreationTime"' => SORT_DESC])
            ->limit(10)->findAll();

        $users = User::model()->byVisible(true)->orderBy(['"t"."CreationTime"' => SORT_DESC])
            ->limit(20)->findAll();

        $orders = Order::model()->byDeleted(false)->byPaid(true)->orderBy(['"t"."PaidTime"' => SORT_DESC])->with(['Event'])
            ->limit(20)->findAll();

        $this->render('index', [
            'waitEvents' => $waitEvents,
            'publishedEvents' => $publishedEvents,
            'users' => $users,
            'orders' => $orders,
            'statistics' => new Statistics()
        ]);
    }
}




