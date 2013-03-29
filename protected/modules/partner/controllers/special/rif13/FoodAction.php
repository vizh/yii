<?php
namespace partner\controllers\special\rif13;

class FoodAction extends \partner\components\Action
{
  const MANAGER_NAME = 'FoodProductManager';

  public function run()
  {
    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."Id" ASC';
    /** @var $products \pay\models\Product[] */
    $products = \pay\models\Product::model()
        ->byEventId(\Yii::app()->partner->getEvent()->Id)
        ->byManagerName(self::MANAGER_NAME)->findAll($criteria);

    $counts = array();
    foreach ($products as $product)
    {
      $counts[$product->Id] = \pay\models\OrderItem::model()
          ->byProductId($product->Id)->byPaid(true)->count();
    }

    $this->getController()->render('rif13/food', array(
      'products' => $products,
      'counts' => $counts
    ));
  }
}
