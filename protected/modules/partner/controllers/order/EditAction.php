<?php
namespace partner\controllers\order;
use application\helpers\Flash;
use partner\components\Action;
use pay\components\Exception;
use pay\models\forms\Juridical;
use pay\models\Order;
use pay\models\OrderLinkOrderItem;
use pay\models\Product;

/**
 * Class EditAction
 *
 * Действие для редактирования счетов
 *
 * @package partner\controllers\order
 */
class EditAction extends Action
{
    //use ProcessOrderItems;

    public function run($id)
    {
        //$this->registerResources();
        $order = Order::model()->byEventId($this->getEvent()->Id)->byPaid(false)->findByPk($id);
        if ($order == null || !$order->getIsBankTransfer()) {
            throw new \CHttpException(404);
        }

        $form = new Juridical($order);
        $request = \Yii::app()->getRequest();
        if ($request->getIsAjaxRequest()) {
            $this->processAjaxMethod($order);
        }

        if ($request->getIsPostRequest()) {
            $form->fillFromPost();
            if ($form->updateActiveRecord() !== null) {
                Flash::setSuccess(\Yii::t('app', 'Cчет успешно сохранен!'));
                $this->getController()->refresh();
            }
        }

        $this->getController()->render('edit', [
            'form' => $form,
            'products' => $this->getProducts(),
            'order' => $order
        ]);
    }

    /**
     * @return \pay\models\Product[]
     */
    private function getProducts()
    {
        return Product::model()->byEventId($this->getEvent()->Id)->excludeRoomManager()->findAll();
    }

    /**
     * Выполняет AJAX запрос
     * @param Order $order
     * @throws \CHttpException
     */
    protected function processAjaxMethod(Order $order)
    {
        $method = \Yii::app()->request->getParam('method');
        $method = 'ajaxMethod'.ucfirst($method);
        if (method_exists($this, $method)) {
            $result = $this->$method($order);
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        } else {
            throw new \CHttpException(404);
        }
        \Yii::app()->end();
    }

    /**
     * @param Order $order
     * @return array
     */
    protected function ajaxMethodGetItemsList(Order $order)
    {
        $result = [];
        foreach ($order->ItemLinks as $link) {
            if (!$link->OrderItem->Paid && !$link->OrderItem->Deleted) {
                $item = new \stdClass();
                $item->Id = $link->OrderItem->Id;
                $item->Owner = $link->OrderItem->Owner->getFullName();
                $item->Product = $link->OrderItem->Product->Title;
                $item->Price = $link->OrderItem->getPriceDiscount().' '.\Yii::t('app', 'руб.');
                $result[] = $item;
            }
        }
        return $result;
    }

    /*
    protected function ajaxMethodDeleteItem()
    {
        $orderItemId = \Yii::app()->request->getParam('OrderItemId');
        $orderItem = \pay\models\OrderItem::model()->byDeleted(false)->byPaid(false)->byEventId($this->getEvent()->Id)->findByPk($orderItemId);
        $result = new \stdClass();
        $result->success = false;

        if ($orderItem !== null)
        {
            $link = \pay\models\OrderLinkOrderItem::model()->byOrderId($this->order->Id)->byOrderItemId($orderItem->Id)->find();
            $link->delete();
            $orderItem->delete();
            $result->success = true;
        }
        else
        {
            $result->error = true;
            $result->message = \Yii::t('app', 'Заказ не найден!');
        }
        return $result;
    }
    */


    /**
     * @return \stdClass
     */
    protected function ajaxMethodCreateItem(Order $order)
    {
        $result = new \stdClass();
        $result->success = false;
        $request = \Yii::app()->getRequest();

        $error = null;
        $product = Product::model()->byEventId($this->getEvent()->Id)->findByPk($request->getParam('ProductId'));
        if ($product == null) {
            $error = \Yii::t('app', 'Продукт не найден!');
        }

        $owner = \user\models\User::model()->byRunetId($request->getParam('RunetId'))->find();
        if ($owner == null) {
            $error = \Yii::t('app', 'Пользователь не найден!');
        }

        if ($error == null) {
            try {
                $orderItem = $product->getManager()->createOrderItem($order->Payer, $owner);
                $link = new OrderLinkOrderItem();
                $link->OrderId = $order->Id;
                $link->OrderItemId = $orderItem->Id;
                $link->save();
            } catch(Exception $e) {
                $error = $e->getMessage();
            }
        }

        if ($error == null) {
            $result->success = true;
        } else {
            $result->error = true;
            $result->message = $error;
        }
        return $result;
    }
} 