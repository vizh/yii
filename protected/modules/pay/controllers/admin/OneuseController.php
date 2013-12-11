<?php

class OneuseController extends \application\components\controllers\AdminMainController
{
  public function actionIbcfood()
  {
    $criteria = new CDbCriteria();
    $criteria->addCondition('"t"."Id" IN (SELECT "UserId" FROM "EventParticipant" WHERE "EventId" = 688 AND "RoleId" IN (2,3,5,6))');
    $criteria->addCondition('"t"."Id" IN (SELECT "OwnerId" FROM "PayOrderItem" WHERE "ProductId" = 1373 AND "Paid")', 'OR');

    $users = \user\models\User::model()->findAll($criteria);

    /** @var \pay\models\Product[] $products */
    $products = [];
    $products[] = \pay\models\Product::model()->findByPk(1376);
    $products[] = \pay\models\Product::model()->findByPk(1377);

    $count = 0;
    foreach ($users as $user)
    {
      foreach ($products as $product)
      {
        $orderItem = \pay\models\OrderItem::model()
            ->byProductId($product->Id)->byOwnerId($user->Id)->find();
        if ($orderItem == null)
          $orderItem = $product->getManager()->createOrderItem($user, $user);
        if (!$orderItem->Paid)
        {
          $orderItem->activate();
          $count++;
        }
      }
    }

    echo $count;

  }

  public function actionCleanOrders()
  {
    $comand = Yii::app()->getDb()->createCommand();

    $comand->select('count("Id"), "EventId", "PayerId"')->from('PayOrder')->where('NOT "Juridical" AND NOT "Receipt" AND NOT "Deleted"');
    $comand->group('EventId, PayerId');
    $comand->having('count("Id") > 1');
    $result = $comand->queryAll();

    echo sizeof($result), '<br>';

    foreach ($result as $row)
    {
      $orders = \pay\models\Order::model()
          ->byEventId($row['EventId'])->byPayerId($row['PayerId'])
          ->byBankTransfer(false)->findAll(['order' => '"t"."CreationTime" DESC']);
      for ($i=1; $i<count($orders); $i++)
      {
        if (!$orders[$i]->Paid)
        {
          $orders[$i]->delete();
        }
      }
    }

    echo 'done';

//    echo '<pre>';
//
//    var_dump($result);
//    echo '</pre>';
  }
} 