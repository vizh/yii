<?
/**
 * @var \user\models\User $user
 */

use pay\models\OrderItem;

$criteria = new \CDbCriteria();
$criteria->with = ['Product'];
$criteria->addCondition('"Product"."ManagerName" = \'RoomProductManager\' AND "t"."Booked" IS NOT NULL');

/** @var OrderItem $orderItem */
$orderItem = OrderItem::model()->byEventId(1534)->byPaid(false)->byDeleted(false)->find($criteria);
?>
<p>Здравствуйте, <?=$user->getShortName()?>!</p>
<p>Напоминаем, что за Вами забронирован номер для проживания в рамках участия в конференции &laquo;РИФ+КИБ 2015&raquo;, следующий категории:</p>

<p>Пансионат <?=$orderItem->Product->getManager()->Hotel?>, строение «<?=$orderItem->Product->getManager()->Housing?>», категория «<?=$orderItem->Product->getManager()->Category?>», с <?=date('d.m.Y', strtotime($orderItem->getItemAttribute('DateIn')))?> по <?=date('d.m.Y', strtotime($orderItem->getItemAttribute('DateOut')))?></p>

<p>На текущий момент данное бронирование номера числится в базе данных мероприятия как &laquo;не оплаченное&raquo;.</p>

<p>В связи с чем, просим подтвердить ваш заказ ответным письмом в наш адрес, сообщить сроки оплаты услуг и направить в наш адрес(<a href="mailto:fin@rif.ru" target="_blank">fin@rif.ru</a>) документ подтверждающий оплату (платежное поручение/квитанция/заявление на перевод) забронированных услуг с отметкой банка &laquo;об исполнении&raquo;.</p>

<p>---</p>

<p>С уважением,<br />
ОРКОМИТЕТ КОНФЕРЕНЦИИ РИФ+КИБ 2015</p>
