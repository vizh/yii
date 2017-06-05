<?php
namespace partner\controllers\special\rif13;

class RoomsAction extends \partner\components\Action
{
    const MANAGER_NAME = 'RoomProductManager';

    private $products = [];

    public function run($hotel = null)
    {
        $attributes = $this->getHotelAttributes();
        $counts = [];
        foreach ($attributes as $attr) {
            if (!isset($counts[$attr->Value])) {
                $counts[$attr->Value] = 0;
            }
            $counts[$attr->Value]++;
        }
        if ($hotel === null) {
            $hotel = $attributes[0]->Value;
        }

        $productIdList = $this->getProductIdListByHotel($hotel);

        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."Id"', $productIdList);
        $criteria->order = '"t"."Id" ASC';
        $products = \pay\models\Product::model()->findAll($criteria);

        $orderItems = $this->getOrderItems($productIdList, $products);

        $this->getController()->render('rif13/rooms', [
            'hotel' => $hotel,
            'counts' => $counts,
            'orderItems' => $orderItems
        ]);
    }

    private function getHotelAttributes()
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('"Product"."EventId" = :EventId');
        $criteria->addCondition('"Product"."ManagerName" = :ManagerName');
        $criteria->addCondition('"t"."Name" = :Name');
        $criteria->params = [
            'EventId' => \Yii::app()->partner->getEvent()->Id,
            'ManagerName' => self::MANAGER_NAME,
            'Name' => 'Hotel'
        ];
        $criteria->with = [
            'Product' => ['together' => true, 'select' => false]
        ];
        $criteria->order = '"t"."Value" ASC';
        /** @var $attributes \pay\models\ProductAttribute[] */
        $attributes = \pay\models\ProductAttribute::model()->findAll($criteria);
        if (sizeof($attributes) === 0) {
            throw new \application\components\Exception('Для данного мероприятия не задан номерной фонд');
        }

        return $attributes;
    }

    private function getProductIdListByHotel($hotel)
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('"Product"."EventId" = :EventId');
        $criteria->addCondition('"Product"."ManagerName" = :ManagerName');
        $criteria->addCondition('"t"."Name" = :Name');
        $criteria->addCondition('"t"."Value" = :Value');
        $criteria->params = [
            'EventId' => \Yii::app()->partner->getEvent()->Id,
            'ManagerName' => self::MANAGER_NAME,
            'Name' => 'Hotel',
            'Value' => $hotel
        ];
        $criteria->with = [
            'Product' => ['together' => true, 'select' => false]
        ];
        /** @var $attributes \pay\models\ProductAttribute[] */
        $attributes = \pay\models\ProductAttribute::model()->findAll($criteria);

        $result = [];
        foreach ($attributes as $attr) {
            $result[] = $attr->ProductId;
        }

        return $result;
    }

    private function getOrderItems($productIdList, $products)
    {
        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."ProductId"', $productIdList);
        $criteria->order = '"t"."ProductId"';

        /** @var $orderItems \pay\models\OrderItem[] */
        $orderItems = \pay\models\OrderItem::model()
            ->byDeleted(false)->byPaid(true, false)->findAll($criteria);

        $dates = ['2013-04-17', '2013-04-18', '2013-04-19'];

        $result = [];
        foreach ($products as $product) {
            $result[$product->Id]['product'] = $product;
            foreach ($dates as $date) {
                $result[$product->Id]['items'][$date] = [];
            }
        }

        foreach ($orderItems as $item) {
            foreach ($dates as $date) {
                if ($date > $item->getItemAttribute('DateIn') && $date <= $item->getItemAttribute('DateOut')) {
                    $result[$item->ProductId]['items'][$date][] = $item;
                }
            }
        }

        return $result;
    }

    public function hasOtherRoom($userId, $orderItemId)
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('"Product"."ManagerName" = :ManagerName');
        $criteria->addCondition('"t"."Id" != :OrderItemId');
        $criteria->addCondition('"Product"."EventId" = :EventId');
        $criteria->with = ['Product' => ['together' => true, 'select' => false]];
        $criteria->params = [
            'ManagerName' => self::MANAGER_NAME,
            'OrderItemId' => $orderItemId,
            'EventId' => \Yii::app()->partner->getEvent()->Id
        ];

        $orderItems = \pay\models\OrderItem::model()
            ->byDeleted(false)->byPaid(true, false)->byPayerId($userId)->findAll($criteria);

        return sizeof($orderItems) !== 0;
    }
}
