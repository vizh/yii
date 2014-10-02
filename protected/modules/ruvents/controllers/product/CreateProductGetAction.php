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

//    $get = \pay\models\ProductGet::model()->byUserId($user->Id)->byProductId($product->Id)->find();
//    if ($get == null)
//    {
      $get = new \pay\models\ProductGet();
      $get->UserId = $user->Id;
      $get->ProductId = $product->Id;
      $get->save();
      $get->refresh();
    //}

      if ($productId == 3036) {
          $badge = new \ruvents\models\Badge();
          $badge->OperatorId = 1534;
          $badge->EventId = $this->getEvent()->Id;
          $badge->UserId = $user->Id;

          $participant = \event\models\Participant::model()->byEventId($this->getEvent()->Id)->byUserId($user->Id)->find();
          if ($participant === null) {
              throw new \ruvents\components\Exception(304);
          }
          $badge->RoleId = $participant->RoleId;
          $badge->save();
      }

    $this->renderJson(['Success' => true, 'CreationTime' => $get->CreationTime]);
  }
} 