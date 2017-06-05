<?php
namespace api\controllers\pay;

use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\ApiAction;

class RifroomsAction extends \api\components\Action
{
    /**
     * @ApiAction(
     *     controller="Pay",
     *     title="Товары",
     *     description="Список доступных товаров, отфильтрованы по менеджеру RoomProductManager",
     *     request=@Request(
     *          method="GET",
     *          url="/pay/rifrooms",
     *          body="",
     *          params="",
     *          response=@Response(body="[{'Id': 'идентификатор','Manager': 'строка, название менеджера (участие, питание и другие)','Title': 'название товара','Price': 'текущая цена','Attributes': 'массив ключ-значение с атрибутами товара'}]")
     *     )
     * )
     */
    public function run()
    {
        //$hotel = \Yii::app()->getRequest()->getParam('Hotel');

        $products = \pay\models\Product::model()
            ->byEventId($this->getEvent()->Id)->byManagerName('RoomProductManager')->findAll();

        $idList = [];
        foreach ($products as $product) {
            $idList[] = $product->Id;
        }
        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."ProductId"', $idList);

        $orderItems = \pay\models\OrderItem::model()->byPaid(true)->findAll($criteria);

        $result = [];
        foreach ($orderItems as $item) {
            $resultItem = new \stdClass();
            $resultItem->Id = $item->Id;
            $owner = $item->ChangedOwner !== null ? $item->ChangedOwner : $item->Owner;
            $resultItem->RunetId = $owner->RunetId;
            $resultItem->FullName = $owner->getFullName();
            $resultItem->DateIn = $item->getItemAttribute('DateIn');
            $resultItem->DateIn = $item->getItemAttribute('DateOut');
            $resultItem->Attributes = [];
            foreach ($item->Product->Attributes as $attr) {
                $resultItem->Attributes[$attr->Name] = $attr->Value;
            }
            $result[] = $resultItem;
        }

        $this->setResult($result);
    }
}