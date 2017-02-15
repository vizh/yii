<?php

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
 *     json="{'Id': 'идентификатор элемента заказа','Product': 'объект Product','Owner': 'объект User (сокращенный, только основные данные пользователя)','PriceDiscount': 'цена с учетом скидки','Paid': 'статус оплаты','PaidTime': 'время оплаты','Attributes': 'массив с атрибутами (если заданы)','Discount': 'размер скидки от 0 до 1, где 0 - скидки нет, 1 - скидка 100%','CouponCode': 'код купона, по которому была получена скидка','GroupDiscount': 'была скидка групповая или нет'}",
 *     description="Зал.",
 *     params={
 *          "Id":"идентификатор",
 *     }
 * )
 */
class PayController extends \api\components\Controller
{
  
}
