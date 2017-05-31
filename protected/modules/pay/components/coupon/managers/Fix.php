<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 15.09.2015
 * Time: 16:35
 */

namespace pay\components\coupon\managers;


class Fix extends Base
{
    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return \Yii::t('app', 'Менеджер фиксированных скидок');
    }

    /**
     * @inheritdoc
     */
    public function getClientDescription()
    {
        return \Yii::t('app', 'Фиксированная скидка');
    }

    /**
     * @inheritdoc
     */
    public function calcDiscountPrice($price)
    {
        return ($price -= $this->coupon->Discount) < 0 ? 0 : $price;
    }

    /**
     * @inheritdoc
     */
    public function getDiscountString()
    {
        return $this->coupon->Discount . ' ' . \Yii::t('app', 'руб') . '.';
    }
}