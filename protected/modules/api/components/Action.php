<?php
namespace api\components;

use Guzzle\Tests\Common\Cache\NullCacheAdapterTest;
use pay\models\OrderItem;
use pay\models\Product;
use Throwable;
use user\models\User;
use Yii;

class Action extends \CAction
{
    /**
     * @return Controller
     */
    public function getController()
    {
        return parent::getController();
    }

    /**
     * @return \api\models\Account
     */
    public function getAccount()
    {
        return $this->getController()->getAccount();
    }

    /**
     * @return builders\Builder
     */
    public function getDataBuilder()
    {
        return $this->getAccount()->getDataBuilder();
    }

    /**
     * @throws Exception
     * @return \event\models\Event
     */
    public function getEvent()
    {
        if ($this->getAccount()->Event == null) {
            throw new \api\components\Exception(301);
        }

        return $this->getAccount()->Event;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->getController()->setResult($result);
    }

    /**
     * @param mixed $result
     */
    public function setSuccessResult()
    {
        $this->getController()->setResult(['Success' => true]);
    }

    /**
     * @return int
     */
    protected function getMaxResults()
    {
        return \Yii::app()->params['ApiMaxResults'];
    }

    /**
     * @return Product
     * @throws Exception
     */
    protected function getRequestedProduct()
    {
        static $product;

        if ($product !== null) {
            return $product;
        }

        try {
            $id = Yii::app()
                ->getRequest()
                ->getParam('ProductId');

            if ($id === null) {
                throw new Exception(110);
            }

            $product = Product::model()
                ->findByPk($id);

            if ($product === null) {
                throw new Exception(413);
            }

            if ($product->EventId !== $this->getEvent()->Id) {
                throw new Exception(402);
            }
        } catch (Exception $e) {
            $product = null;
            throw $e;
        } catch (Throwable $e) {
            $product = null;
            throw new Exception(100, [$e->getMessage()]);
        }

        return $product;
    }

    protected function getRequestedOrderItem()
    {
        static $orderItem;

        if ($orderItem !== null) {
            return $orderItem;
        }

        try {
            $id = Yii::app()
                ->getRequest()
                ->getParam('OrderItemId');

            Yii::log(sprintf('OrderItemId: %d', $id));

            if ($id === null) {
                throw new Exception(110);
            }

            $orderItem = OrderItem::model()
                ->findByPk($id);

            if ($orderItem === null) {
                throw new Exception(409);
            }

            if ($orderItem->Product->EventId !== $this->getEvent()->Id) {
                throw new Exception(402);
            }

            Yii::log(sprintf('$orderItem->PayerId = %d; $this->getRequestedPayer()->Id = %d', $orderItem->PayerId, $this->getRequestedPayer()->RunetId));
            if ($orderItem->PayerId !== $this->getRequestedPayer()->Id) {
                throw new Exception(410);
            }

            if ($orderItem->Paid) {
                throw new Exception(411);
            }
        } catch (Exception $e) {
            $orderItem = null;
            throw $e;
        } catch (Throwable $e) {
            $orderItem = null;
            throw new Exception(100, [$e->getMessage()]);
        }

        return $orderItem;
    }

    protected function getRequestedPayer()
    {
        static $payer;

        if ($payer !== null) {
            return $payer;
        }

        try {
            $id = Yii::app()
                ->getRequest()
                ->getParam('PayerRunetId');

            Yii::log(sprintf('PayerRunetId: %d', $id));

            if ($id === null) {
                throw new Exception(202, [$id]);
            }

            $payer = User::model()
                ->byRunetId($id)
                ->find();

            if ($payer === null) {
                throw new Exception(202, [$payer]);
            }
        } catch (Exception $e) {
            $payer = null;
            throw $e;
        } catch (Throwable $e) {
            $payer = null;
            throw new Exception(100, [$e->getMessage()]);
        }

        return $payer;
    }
}
