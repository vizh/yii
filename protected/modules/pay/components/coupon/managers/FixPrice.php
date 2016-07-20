<?php

namespace pay\components\coupon\managers;


class FixPrice extends Base
{
    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return \Yii::t('app', 'Менеджер сидки фиксированной суммы заказа');
    }

    /**
     * @inheritdoc
     */
    public function getClientDescription()
    {
        return \Yii::t('app', 'Скидка фиксированной суммы заказа');
    }

    /**
     * @inheritdoc
     */
    public function calcDiscountPrice($price)
    {
        return $this->coupon->Discount;
    }

    /**
     * @inheritdoc
     */
    public function getDiscountString()
    {
        return $this->coupon->Discount . ' ' . \Yii::t('app', 'руб') . '.';
    }
}