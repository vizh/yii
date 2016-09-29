<?=$user->getShortName()?>, добрый день!

<?=\Yii::app()->dateFormatter->format('dd MMMM yyyy HH:mm', $order->CreationTime)?> вами был забронирован номер в <?=$order->ItemLinks[0]->OrderItem->Product->getManager()->Hotel?> на срок с <?=\Yii::app()->dateFormatter->format('dd', $order->ItemLinks[0]->OrderItem->getItemAttribute('DateIn'))?> по <?=\Yii::app()->dateFormatter->format('dd MMMM yyyy', $order->ItemLinks[0]->OrderItem->getItemAttribute('DateOut'))?>.

Бронь номера привязана к счету <?=$order->Id?>:
<?=$order->getUrl()?>


Срок брони истекает <?=\Yii::app()->dateFormatter->format('dd MMMM yyyy HH:mm', $order->ItemLinks[0]->OrderItem->Booked)?>. На момент отправки этого уведомления мы не получили оплаты по данному счету.

В случае, если номер не будет оплачен до момента истечения брони, он автоматически будет выставлен в открытую продажу.

При оплате 27 или 28 апреля рекомендуем направить нам скан платежного поручения с отметкой банка об оплате.

---
Служба поддержки участников
РИФ+КИБ 2013
users@rif.ru
www.rif.ru