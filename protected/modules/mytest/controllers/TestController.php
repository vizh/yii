<?php

/**
 * Created by IntelliJ IDEA.
 * User: Alaris
 * Date: 3/13/13
 * Time: 3:17 PM
 * To change this template use File | Settings | File Templates.
 */
class TestController extends CController
{
    public function actionIndex()
    {
        $manager = 'RoomProductManager';
        $params = [
            'DateIn' => '2013-04-16',
            'DateOut' => '2013-04-19',
            'Hotel' => 'НАЗАРЬЕВО',
            'Housing' => '2 корпус',
            'Category' => 'джуниор суит стандартный',
            'PlaceTotal' => '3'
        ];
        $filter = [
            'Price'
        ];

        /** @var $product \pay\models\Product */
        $product = \pay\models\Product::model()
            ->byManagerName($manager)
            ->byEventId(422)->find();

        if ($product === null) {
            throw new \api\components\Exception(420);
        }

        $filterResult = $product->getManager()->filter($params, $filter);
        var_dump($filterResult);

        //$product = $product->getManager()->getFilterProduct($params);

        //var_dump($product);
    }

    public function actionOrder()
    {
        $orderId = 10531;
        /** @var $order \pay\models\Order */
        $order = \pay\models\Order::model()->findByPk($orderId);

        $result = $order->activate();

        var_dump($result);
    }

    public function actionTotal()
    {
        return;
        $criteria = new CDbCriteria();
        $criteria->addCondition('"t"."Total" IS NOT NULL');
        $criteria->addCondition('"t"."PaidTime" <= :PaidTime');
        $criteria->params = ['PaidTime' => '2013-10-11 14:10:38'];
        $criteria->order = '"t"."Id" DESC';

        /** @var $orders \pay\models\Order[] */
        $orders = \pay\models\Order::model()->byEventId(688)->byPaid(true)->findAll($criteria);

        $count = 0;
        $delta = 0;
        $sum1 = 0;
        $sum2 = 0;
        foreach ($orders as $order) {
            $price = $order->getPrice();
            echo $order->Id.': '.$order->Total.' '.$price.' '.($order->Total - $price).'<br>';
            $sum1 += $order->Total;
            $sum2 += $price;
        }

        echo $sum1.' '.$sum2;
    }

    public function actionCall()
    {
        $data = new \stdClass();
        $data->ApiKey = 'zrnzd5rs8i';
        $data->ExternalId = 'e005fddf-5093-44f7-9527-a5e68e8953f8';
        $data->RoleId = 1;
        $data->Hash = md5($data->ApiKey.$data->ExternalId.$data->RoleId.'YzyrQiHRGDZhsh7ENiRi6YdE5');
        $params = ['PayData' => json_encode($data)];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://runet-id.com/mytest/test/back');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        $result = curl_exec($curl);

        echo $result;

        $errno = curl_errno($curl);
        $errmessage = curl_error($curl);

        echo $errno, $errmessage;
    }

    public function actionBack()
    {
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
    }
}
