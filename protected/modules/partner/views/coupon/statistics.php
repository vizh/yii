<?php
/**
 * @var Coupon $coupon
 * @var int $paidCount
 * @var int $paidTotal
 */
use pay\models\Coupon;

?>

<h3>Промо-код: <span class="text-success"><?=$coupon->Code;?></span></h3>

<p class="lead">Скидка: <?=100*$coupon->Discount;?>%</p>


<p class="lead">Доступно активаций промо-кода: <?=$coupon->Multiple ? $coupon->MultipleCount : 1;?></p>
<p class="lead">Активировано пользователями: <span><?=count($coupon->Activations);?></span></p>

<p class="lead">Количество оплат: <span><?=$paidCount;?></span></p>

<p class="lead">Сумма оплат: <span class="text-success"><?=$paidTotal;?> руб.</span></p>