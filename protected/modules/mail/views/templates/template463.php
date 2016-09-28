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
<p>Здравствуйте, <?=$user->getShortName()?>!</p>


<p>Вы, как участник РИФа, можете воспользоваться уникальным предложением:<br/>
 зарегистрироваться на&nbsp;<strong>Большой Медиа-Коммуникационный Форум</strong> (МКФ-2015&nbsp;— <a href="http://www.mcf.moscow">www.MCF.moscow</a>) в&nbsp;статусе <strong>Профессионального участника&nbsp;— БЕСПЛАТНО ДО&nbsp;30&nbsp;АПРЕЛЯ! </strong>
</p>
<p>Этот статус дает возможность принимать участие в&nbsp;работе всех <a href="http://mcf.moscow/program/">5&nbsp;залов МКФ</a> и&nbsp;посещать выставку «Связь-Экспокомм» в&nbsp;течение всех дней проведения мероприятия, с&nbsp;12&nbsp;по&nbsp;14&nbsp;мая.</p>
<h3 style="margin-bottom: 5px">РЕГИСТРАЦИЯ</h3>
<p>Для активации предложения вам необходимо перейти в&nbsp;личный кабинет по&nbsp;персональной ссылке ниже и&nbsp;активировать там промо-код: <strong style="background-color: #05AFED; color: #ffffff; display: inline-block; padding: 2px 4px;"><?=$discount->Code?></strong>
</p>

<div class="bordered center" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; text-align: center; margin: 15px 0; padding: 25px; border: 1px solid #05afed;" align="center">
	<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 0px; padding: 0;"><a href="<?=$reglink?>" class="btn-primary" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 2; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; background: #05AFED; margin: 0 10px 0 0; padding: 0; border-color: #05afed; border-style: solid; border-width: 10px 40px;">ЛИЧНЫЙ КАБИНЕТ</a></p>
</div>
<h3 style="margin-bottom: 5px">ВНИМАНИЕ!</h3>
<p>Предложение действительно до&nbsp;30&nbsp;апреля. При регистрации после 1&nbsp;мая промо-код аннулируется, но&nbsp;для Вас и&nbsp;Ваших коллег сохранится возможность получения скидки&nbsp;50%, которую&nbsp;Вы сможете дополнительно запросить по&nbsp;e-mail у&nbsp;Оргкомитета МКФ 2015&nbsp;— <a href="mailto:users@MCF.moscow">users@MCF.moscow</a>.
</p>
<p>Ждем Вас на&nbsp;мероприятии! </p>
