<?php
namespace pay\components\managers;
use mail\components\mailers\MandrillMailer;
use string;

/**
 * Class Ticket
 * @property int $ProductId
 */
class Ticket extends BaseProductManager
{
    protected $paidProduct;

    public function __construct($product)
    {
        parent::__construct($product);
        $this->paidProduct = \pay\models\Product::model()->findByPk($this->ProductId);
    }

    /**
     * @inheritdoc
     */
    public function getOrderItemAttributeNames()
    {
        return array_merge(['Count'], parent::getOrderItemAttributeNames());
    }

    /**
     * @inheritdoc
     */
    public function getRequiredOrderItemAttributeNames()
    {
        return ['Count'];
    }

    /**
     * @inheritdoc
     */
    public function getProductAttributeNames()
    {
        return array_merge(['ProductId'], parent::getProductAttributeNames());
    }

    /**
     * @inheritdoc
     */
    public function getRequiredProductAttributeNames()
    {
        return ['ProductId'];
    }


    public function checkProduct($user, $params = [])
    {
        return true;
    }

    /**
     * Оформляет покупку продукта на пользователя
     *
     * @param \user\models\User $user
     * @param \pay\models\OrderItem $orderItem
     * @param array $params
     *
     * @return bool
     */
    protected function internalBuyProduct($user, $orderItem = null, $params = array())
    {
        $coupons = [];
        for ($i = 0; $i < $orderItem->getItemAttribute('Count'); $i++)
        {
            $coupon = new \pay\models\Coupon();
            $coupon->EventId = $this->product->EventId;
            $coupon->Code = 'ticket-'.$coupon->generateCode();
            $coupon->OwnerId = $user->Id;
            $coupon->Discount = 1;
            $coupon->IsTicket = true;
            $coupon->save();
            $coupon->addProductLinks([$this->product]);
            $coupons[] = $coupon;
        }

        $event = new \CModelEvent($this, ['payer' => $user, 'product' => $this->paidProduct, 'coupons' => $coupons]);
        $mail = new \pay\components\handlers\buyproduct\Ticket(new MandrillMailer(), $event);
        $mail->send();
        return true;
    }

    /**
     * Отменяет покупку продукта на пользовтеля
     * @param \user\models\User $user
     * @return bool
     */
    public function rollbackProduct($user)
    {
        return false;
    }

    /**
     *
     * @param \user\models\User $fromUser
     * @param \user\models\User $toUser
     * @param array $params
     *
     * @return bool
     */
    protected function internalChangeOwner($fromUser, $toUser, $params = array())
    {
        return false;
    }

    public function filter($params, $filter)
    {
        return [];
    }

    public function getFilterProduct($params)
    {
        return $this->product;
    }

    public function getPrice($orderItem)
    {
        $count = intval($orderItem->getItemAttribute('Count'));
        return $count * parent::getPrice($orderItem);
    }

    public function getPriceByTime($time = null)
    {
        return $this->getPaidProduct()->getPrice($time);
    }

    public function getTitle($orderItem)
    {
        return !empty($this->getPaidProduct()->OrderTitle) ? $this->getPaidProduct()->OrderTitle : $this->getPaidProduct()->Title;
    }

    /**
     * @return \pay\models\Product
     */
    public function getPaidProduct()
    {
        return $this->paidProduct;
    }

    public function getCount($orderItem)
    {
        return $orderItem->getItemAttribute('Count');
    }
}