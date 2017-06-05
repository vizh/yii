<?php
namespace partner\controllers\internal;

class PhdaysoptionAction extends \partner\components\Action
{
    public function run()
    {
        //return;
        $productId = [1058, 1059, 1060];

        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."ProductId"', $productId);
        $orderItems = \pay\models\OrderItem::model()->byPaid(true)->findAll($criteria);

        $users = [];
        foreach ($orderItems as $item) {
            $users[] = $item->ChangedOwner != null ? $item->ChangedOwner : $item->Owner;
        }

        $product = \pay\models\Product::model()->findByPk(1327);
        if ($product == null) {
            echo 'wrong product';
            return;
        }

        foreach ($users as $user) {
            echo $user->RunetId.'<br>';
            //$user->save();
            //$product->getManager()->createOrderItem($user, $user);
        }

        echo sizeof($users);
    }
}