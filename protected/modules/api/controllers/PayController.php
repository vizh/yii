<?php

use api\components\Controller;
use nastradamus39\slate\annotations\ApiController;
use nastradamus39\slate\annotations\ApiObject;

/**
 * @ApiController(
 *     controller="Pay",
 *     title="Платежный кабинет",
 *     description="Методы для работы с платежным кабинетом."
 * )
 * @ApiObject(
 *     code="ORDER",
 *     title="Заказ",
 *     json="{
'Id': 'идентификатор элемента заказа',
'Product': 'объект Product',
'Owner': 'объект User (сокращенный, только основные данные пользователя)',
'PriceDiscount': 'цена с учетом скидки',
'Paid': 'статус оплаты',
'PaidTime': 'время оплаты',
'Attributes': 'массив с атрибутами (если заданы)',
'Discount': 'размер скидки от 0 до 1, где 0 - скидки нет, 1 - скидка 100%',
'CouponCode': 'код купона, по которому была получена скидка',
'GroupDiscount': 'была скидка групповая или нет'
}",
 *     description="Зал.",
 *     params={
 *          "Id":"идентификатор",
 *     }
 * )
 * @ApiObject(
 *     code="ITEM",
 *     title="Оплаченный заказ",
 *     json="{
'Id': 'идентификатор элемента заказа',
'Product': 'объект Product',
'Owner': 'объект User (сокращенный, только основные данные пользователя)',
'PriceDiscount': 'цена с учетом скидки',
'Paid': 'статус оплаты',
'PaidTime': 'время оплаты',
'Attributes': 'массив с атрибутами (если заданы)',
'Discount': 'размер скидки от 0 до 1, где 0 - скидки нет, 1 - скидка 100%',
'CouponCode': 'код купона, по которому была получена скидка',
'GroupDiscount': 'была скидка групповая или нет'
}",
 *     description="Оплаченный заказ.",
 *     params={
 *          "Id":"идентификатор",
 *     }
 * )
 * @ApiObject(
 *     code="PRODUCT",
 *     title="Товар",
 *     json="{
'Id': 'идентификатор',
'Manager': 'строка, название менеджера (участие, питание и другие)',
'Title': 'название товара',
'Price': 'текущая цена',
'Attributes': 'массив ключ-значение с атрибутами товара'
}",
 *     description="Оплаченный заказ.",
 *     params={
 *          "Id":"идентификатор",
 *     }
 * )
 */
class PayController extends Controller
{
    public function actions()
    {
        return [
            'add' => '\api\controllers\pay\AddAction',
            'coupon' => '\api\controllers\pay\CouponAction',
            'delete' => '\api\controllers\pay\DeleteAction',
            'edit' => '\api\controllers\pay\EditAction',
            'filterBook' => '\api\controllers\pay\FilterBookAction',
            'filterList' => '\api\controllers\pay\FilterListAction',
            'items' => '\api\controllers\pay\ItemsAction',
            'list' => '\api\controllers\pay\ListAction',
            'product' => '\api\controllers\pay\ProductAction',
            'products' => '\api\controllers\pay\ProductsAction',
            'rifrooms' => '\api\controllers\pay\RifroomsAction',
            'url' => '\api\controllers\pay\UrlAction'
        ];
    }
}
