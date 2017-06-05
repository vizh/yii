<?php
namespace pay\components\coupon\managers;

class Percent extends Base
{
    /**
     * @inheritdoc
     */
    public function calcDiscountPrice($price)
    {
        return $price - $price * $this->coupon->Discount / 100;
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return \Yii::t('app', 'Менеджер процентных скидок');
    }

    /**
     * @inheritdoc
     */
    public function getClientDescription()
    {
        return \Yii::t('app', 'Процентная скидка');
    }

    /**
     * @inheritdoc
     */
    public function getDiscountString()
    {
        return $this->coupon->Discount.'%';
    }
}