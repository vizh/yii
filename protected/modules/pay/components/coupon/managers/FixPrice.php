<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 17.09.2015
 * Time: 13:44
 */

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