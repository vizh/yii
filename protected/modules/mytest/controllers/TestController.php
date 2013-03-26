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
    $params = array(
      'DateIn' => '2013-04-16',
      'DateOut' => '2013-04-19',
      'Hotel' => 'НАЗАРЬЕВО',
      'Housing' => '2 корпус',
      'Category' => 'джуниор суит стандартный',
      'PlaceTotal' => '3'
    );
    $filter = array(
      'Price'
    );

    /** @var $product \pay\models\Product */
    $product = \pay\models\Product::model()
        ->byManagerName($manager)
        ->byEventId(422)->find();

    if ($product === null)
    {
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

    /** @var $orders \pay\models\Order[] */
    $orders = \pay\models\Order::model()->findAll($criteria);

    $count = 0;
    $delta = 0;
    foreach ($orders as $order)
    {
      if ($order->getPrice() > $order->Total)
      {
        echo $order->Id . ($order->Juridical ? ' (юридический)' : ' (физический)') . ' ' . $order->Payer->getFullName() . ' ' . $order->Payer->Email . ' Доплатить:' . ($order->getPrice() - $order->Total) . '<br>';
        $count++;
        $delta += $order->getPrice() - $order->Total;
      }
    }

  }
}
