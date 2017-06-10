<?php

use application\components\controllers\AjaxController as AjaxControllerTrait;
use application\components\helpers\ArrayHelper;
use partner\components\Controller;
use pay\components\CodeException as PayCodeException;
use pay\components\collection\Finder;
use pay\components\Exception as PayException;
use pay\components\OrderItemCollection;
use pay\models\Order;
use pay\models\OrderItem;
use pay\models\OrderLinkOrderItem;
use pay\models\Product;
use user\models\User;

class AjaxController extends Controller
{
    use AjaxControllerTrait;

    /**
     * Список заказов для пользователя
     * @throws CHttpException
     */
    public function actionOrderItems()
    {
        $result = [];

        $payer = $this->getPayer();
        if ($this->getOrder() !== null) {
            $collection = OrderItemCollection::createByOrder($this->getOrder());
        } else {
            $finder = Finder::create($this->getEvent()->Id, $payer->Id);
            $collection = $finder->getUnpaidFreeCollection();
        }

        foreach ($collection as $collectionItem) {
            $orderItem = $collectionItem->getOrderItem();
            $item['Id'] = $orderItem->Id;
            $item['owner'] = $this->renderPartial('partner.views.partial.grid.user', ['user' => $orderItem->Owner], true);
            $item['product'] = ArrayHelper::toArray($orderItem->Product, ['pay\models\Product' => ['Id', 'Title', 'Price', 'Description']]);
            $item['discount'] = $collectionItem->getDiscount();
            $item['orderItemId'] = $orderItem->Id;
            $item['price'] = $collectionItem->getPriceDiscount();
            $result[] = $item;
        }

        $this->returnJSON($result);
    }

    /**
     * Добавление заказа
     * @param int $ownerRunetId
     * @param int $productId
     */
    public function actionAddOrderItem($ownerRunetId, $productId)
    {
        $result = new \stdClass();

        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $owner = User::model()->byRunetId($ownerRunetId)->find();
            if ($owner === null) {
                throw new PayCodeException(PayCodeException::NO_EXISTS_ORDER_ITEM_OWNER);
            }

            $product = Product::model()->byEventId($this->getEvent()->Id)->findByPk($productId);
            if ($product === null) {
                throw new PayCodeException(PayCodeException::NO_EXISTS_PRODUCT);
            }

            $orderItem = $product->getManager()->createOrderItem($this->getPayer(), $owner);

            if ($this->getOrder() !== null) {
                $link = new OrderLinkOrderItem();
                $link->OrderId = $this->getOrder()->Id;
                $link->OrderItemId = $orderItem->Id;
                $link->save();
            }
            $result->success = true;
            $result->orderItemId = $orderItem->Id;
            $result->price = $orderItem->getPriceDiscount();
            $transaction->commit();
        } catch (PayException $e) {
            $result->error = true;
            $result->message = $e->getMessage();
        }
        $this->returnJSON($result);
    }

    /**
     * Удаление заказа
     * @param int $id
     * @return string
     */
    public function actionDeleteOrderItem($id)
    {
        $result = new \stdClass();
        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $orderItem = OrderItem::model()->byPayerId($this->getPayer()->Id)->byEventId($this->getEvent()->Id)->byPaid(false)->findByPk($id);
            if ($orderItem === null) {
                throw new PayCodeException(PayCodeException::NO_EXISTS_ORDER_ITEM);
            }

            if ($this->getOrder() !== null) {
                $link = $this->getOrder()->getItemLink($orderItem);
                $link->delete();
            }

            $orderItem->delete();
            $result->success = true;
            $transaction->commit();
        } catch (PayException $e) {
            $result->error = true;
            $result->message = $e->getMessage();
        }
        $this->returnJSON($result);
    }

    /**
     * Поиск пользователей
     * @param string $term
     */
    public function actionUsers($term)
    {
        $model = User::model()->with(['Settings', 'Employments']);
        if (strpos($term, '@')) {
            $model->byEmail($term);
        } else {
            $model->bySearch($term, null, true, false);
        }
        $model->limit(10);

        $result = [];
        foreach ($model->findAll() as $user) {
            $employment = $user->getEmploymentPrimary();

            $result[] = [
                'value' => $user->RunetId,
                'label' => $user->getFullName().($employment !== null ? ' ('.$employment.')' : '')
            ];
        }
        $this->returnJSON($result);
    }

    /** @var bool|null|Order */
    private $order = false;

    /**
     * @return null|Order
     * @throws PayCodeException
     */
    private function getOrder()
    {
        if ($this->order === false) {
            $id = \Yii::app()->getRequest()->getParam('orderId');
            if ($id !== null) {
                $this->order = Order::model()->byEventId($this->getEvent()->Id)->byPayerId($this->getPayer()->Id)->findByPk($id);
                if ($this->order === null) {
                    throw new PayCodeException(PayCodeException::NO_EXISTS_ORDER, [$id]);
                }
            } else {
                $this->order = null;
            }
        }
        return $this->order;
    }

    /** @var null|Order */
    private $payer;

    /**
     * @return User
     * @throws PayCodeException
     */
    private function getPayer()
    {
        if ($this->payer === null) {
            $id = \Yii::app()->getRequest()->getParam('payerRunetId');
            $this->payer = User::model()->byRunetId($id)->find();
            if ($this->payer === null) {
                throw new PayCodeException(PayCodeException::NO_EXISTS_ORDER_ITEM_PAYER);
            }
        }
        return $this->payer;
    }
}