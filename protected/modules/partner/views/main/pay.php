<?php
/**
 * @var $allOrdersCount int
 * @var $paidOrdersCount int
 * @var $totalJuridical int
 * @var $paidPhysicalItemsCount int
 * @var $totalPhysical int
 */
?>
<style type="text/css">
  .label {font-size: 16px;}
</style>

<h1 class="indent-bottom3">Статистика по платежам</h1>
<div class="row indent-bottom3">
  <div class="span4">
    <h2 class="indent-bottom1">Юридические лица:</h2>
    <p>Выставлено счетов: <span class="label"><?=$allOrdersCount;?></span></p>
    <p>Из них оплачено: <span class="label label-success"><?=$paidOrdersCount;?></span></p>
    <p>На сумму: <span class="label label-warning"><?=$totalJuridical;?> руб.</span></p>
  </div>
  <div class="span4 offset4">
    <h2 class="indent-bottom1">Физические лица:</h2>
    <p>Оплатили товаров: <span class="label label-success"><?=$paidPhysicalItemsCount;?></span></p>
    <p>На сумму: <span class="label label-warning"><?=$totalPhysical;?> руб.</span></p>
  </div>
</div>