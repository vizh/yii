<?php
namespace ruvents\controllers\product;


class CreateProductGetAction extends \ruvents\components\Action
{
  public function run($runetId, $productId)
  {
    $user = \user\models\User::model()->byRunetId($runetId)->byEventId($this->getEvent()->Id)->find();
    if ($user == null)
      throw new \ruvents\components\Exception(202,[$runetId]);

    $product = \pay\models\Product::model()->byEventId($this->getEvent()->Id)->findByPk($productId);
    if ($product == null)
      throw new \ruvents\components\Exception(401,[$productId]);

    $get = \pay\models\ProductGet::model()->byUserId($user->Id)->byProductId($product->Id)->find();
    if ($get == null)
    {
      $get = new \pay\models\ProductGet();
      $get->UserId = $user->Id;
      $get->ProductId = $product->Id;
      $get->save();
      $get->refresh();
    }

    $this->renderJson(['Success' => true, 'CreationTime' => $get->CreationTime]);
  }
} 