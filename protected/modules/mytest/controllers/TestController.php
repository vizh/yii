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
}
