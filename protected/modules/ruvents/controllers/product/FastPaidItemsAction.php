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
    public function run($productId, $fromTime = null)
    {
        $criteria = new \CDbCriteria();
        $criteria->with = [
            'Owner',
            'ChangedOwner'
        ];
        if (!empty($fromTime))
        {
            $datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $fromTime);
            if ($datetime === false)
                throw new \ruvents\components\Exception(321);

            $criteria->addCondition('"t"."CreationTime" >= :Time');
            $criteria->params['Time'] = $datetime->format('Y-m-d H:i:s');
        }

        $items = \pay\models\OrderItem::model()
            ->byProductId($productId)->byPaid(true)->findAll($criteria);

        $result = [];
        $maxCreationTime = '1970-01-01 00:00:00';
        foreach ($items as $item)
        {
            $owner = $item->ChangedOwnerId != null ? $item->ChangedOwner : $item->Owner;
            $result[] = $owner->RunetId;

            if ($item->CreationTime > $maxCreationTime)
                $maxCreationTime = $item->CreationTime;
        }

        $data = new \stdClass();
        $data->Owners = $result;
        $data->MaxCreationTime = $maxCreationTime;

        $this->renderJson($data);
    }
} 