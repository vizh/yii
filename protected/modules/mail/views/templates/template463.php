<?php
/**
 * @var \user\models\User $user
 */
$reglink  = "http://mcf.moscow/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'v1ea8anfiv'), 0, 16);
$discount = new \pay\models\Coupon();
$discount->EventId  = 1739;
$discount->Code = $discount->generateCode();
$discount->EndTime  = '2015-04-30 23:59:59';
$discount->Discount = 1;
$discount->save();

$product = \pay\models\Product::model()->findByPk(3647);
$discount->addProductLinks([$product]);
?>
<p>Здравствуйте, <?=$user->getShortName();?>!</p>

<p>Вы, как участник РИФа, можете воспользоваться уникальным предложением и посетить Большой Медиа-Коммуникационный Форум (МКФ-2015) со статус Профессионального участника на специальных условиях - БЕСПЛАТНО!</p>

<p>Этот статус дает возможность неограниченно принимать участие в работе всех 5 залов МКФ и посещать выставку &quot;Связь-Экспокомм&quot; в течение всех дней&nbsp; проведения мероприятия, с 12 по 14 мая.</p>

<p>Для активации предложения вам необходимо перейти в личный кабинет по персональной ссылке ниже и активировать там промо-код: <strong><?=$discount->Code;?></strong></p>

<div class="bordered center" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; text-align: center; margin: 15px 0; padding: 25px; border: 1px solid #05afed;" align="center">
	<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 0px; padding: 0;"><a href="<?=$reglink?>" class="btn-primary" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 2; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; background: #05AFED; margin: 0 10px 0 0; padding: 0; border-color: #05afed; border-style: solid; border-width: 10px 40px;">ЛИЧНЫЙ КАБИНЕТ</a></p>
</div>

<p>Предложение действительно до конца месяца. При регистрации после 1 мая промо-код аннулируется, но для Вас и Ваших коллег сохранится возможность получения скидки 50%, которую Вы сможете дополнительно запросить по e-mail у Оргкомитета МКФ 2015&quot;.</p>
