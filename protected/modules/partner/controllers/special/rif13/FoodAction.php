<?php
namespace partner\controllers\special\rif13;

class FoodAction extends \partner\components\Action
{
  const MANAGER_NAME = 'FoodProductManager';

  public function run()
  {
    $breakfast = array(897, 902, 906);
    $polyani = array(899, 901, 904, 908) ;

    $sosniHotelId = $this->getProductsId('Сосны');
    $nazarHotelId = $this->getProductsId('НАЗАРЬЕВО');
    $ldHotelId = $this->getProductsId('ЛЕСНЫЕ ДАЛИ');


    $sosniUsers = $this->getUsersId($sosniHotelId);
    $nazarUsers = $this->getUsersId($nazarHotelId);
    $ldUsers = $this->getUsersId($ldHotelId);

    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."Id" ASC';
    /** @var $products \pay\models\Product[] */
    $products = \pay\models\Product::model()
        ->byEventId(\Yii::app()->partner->getEvent()->Id)
        ->byManagerName(self::MANAGER_NAME)->findAll($criteria);

    $ldCounts = array();
    $criteria = new \CDbCriteria();
    $criteria->addInCondition('"t"."OwnerId"', $ldUsers);
    $criteria->addInCondition('"t"."ChangedOwnerId"', $ldUsers, 'OR');
    foreach ($products as $product)
    {
      if (!in_array($product->Id, $polyani))
      {
        $ldCounts[$product->Id] = \pay\models\OrderItem::model()
            ->byProductId($product->Id)->byPaid(true)->count($criteria);
      }
    }

    $sosniCounts = array();
    $criteria = new \CDbCriteria();
    $criteria->addInCondition('"t"."OwnerId"', $sosniUsers);
    $criteria->addInCondition('"t"."ChangedOwnerId"', $sosniUsers, 'OR');
    foreach ($products as $product)
    {
      if (in_array($product->Id, $breakfast))
      {
        $sosniCounts[$product->Id] = \pay\models\OrderItem::model()
            ->byProductId($product->Id)->byPaid(true)->count($criteria);
      }
    }

    $nazarCounts = array();
    $criteria = new \CDbCriteria();
    $criteria->addInCondition('"t"."OwnerId"', $nazarUsers);
    $criteria->addInCondition('"t"."ChangedOwnerId"', $nazarUsers, 'OR');
    foreach ($products as $product)
    {
      if (in_array($product->Id, $breakfast))
      {
        $nazarCounts[$product->Id] = \pay\models\OrderItem::model()
            ->byProductId($product->Id)->byPaid(true)->count($criteria);
      }
    }

    $counts = array();
    $polyaniCounts = array();
    foreach ($products as $product)
    {
      $counts[$product->Id] = $polyaniCounts[$product->Id] = \pay\models\OrderItem::model()
          ->byProductId($product->Id)->byPaid(true)->count();

      $polyaniCounts[$product->Id] -= isset($sosniCounts[$product->Id]) ? $sosniCounts[$product->Id] : 0;
      $polyaniCounts[$product->Id] -= isset($nazarCounts[$product->Id]) ? $nazarCounts[$product->Id] : 0;
      $polyaniCounts[$product->Id] -= isset($ldCounts[$product->Id]) ? $ldCounts[$product->Id] : 0;
    }

    $this->getController()->render('rif13/food', array(
      'products' => $products,
      'counts' => $counts,
      'polyaniCounts' => $polyaniCounts,
      'ldCounts' => $ldCounts,
      'sosniCounts' => $sosniCounts,
      'nazarCounts' => $nazarCounts,
    ));
  }

  private function getProductsId($hotelName)
  {
    $criteria = new \CDbCriteria();
    $criteria->addCondition('"Attributes"."Name" = :Name');
    $criteria->addCondition('"Attributes"."Value" = :Value');
    $criteria->params = array(
      'Name' => 'Hotel',
      'Value' => $hotelName
    );
    $criteria->with = array(
      'Attributes' => array('together' => true)
    );

    /** @var $products \pay\models\Product[] */
    $products = \pay\models\Product::model()
        ->byManagerName('RoomProductManager')->byEventId($this->getEvent()->Id)->findAll($criteria);
    $result = array();
    foreach ($products as $product)
    {
      $result[] = $product->Id;
    }
    return $result;
  }

  private function getUsersId($productList)
  {
    $criteria = new \CDbCriteria();
    $criteria->addInCondition('"t"."ProductId"', $productList);

    $orderItems = \pay\models\OrderItem::model()->byPaid(true)->findAll($criteria);
    $result = array();
    foreach ($orderItems as $item)
    {
      $result[] = $item->OwnerId;
    }
    return $result;
  }
}
