<?php
namespace ruvents\controllers\product;

/**
 * Данный метод используется для быстрой загрузки списка RunetId пользователей, оплативших
 * определенный товар
 *
 * Class FastPaidItemsAction
 * @package ruvents\controllers\product
 */
class FastPaidItemsAction extends \ruvents\components\Action
{
    public function run($productId)
    {
        $criteria = new \CDbCriteria();
        $criteria->with = [
            'Owner',
            'ChangedOwner'
        ];
        $items = \pay\models\OrderItem::model()
            ->byProductId($productId)->byPaid(true)->findAll($criteria);

        $result = [];
        foreach ($items as $item)
        {
            $owner = $item->ChangedOwnerId != null ? $item->ChangedOwner : $item->Owner;
            $result[] = $owner->RunetId;
        }

        $this->renderJson($result);
    }
} 