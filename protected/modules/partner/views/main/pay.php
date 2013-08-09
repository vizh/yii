<?php
/**
 * @var $statistics \partner\controllers\main\PayStatistics
 * @var $oldStatistics \partner\controllers\main\PayStatistics
 */
?>
<style type="text/css">
  .label {font-size: 16px;}
</style>

<h1 class="indent-bottom3">Статистика по платежам</h1>
<div class="row indent-bottom4">
  <div class="span4">
    <h2 class="indent-bottom1">Юридические лица:</h2>
    <p>Выставлено счетов: <span class="label"><?=$statistics->countJuridicalOrders;?></span></p>
    <p>Из них оплачено: <span class="label label-success"><?=$statistics->countPaidJuridicalOrders;?></span></p>
    <p>На сумму: <span class="label label-warning"><?=$statistics->totalJuridical;?> руб.</span></p>
  </div>
  <div class="span4 offset4">
    <h2 class="indent-bottom1">Физические лица:</h2>
    <p>Оплачено счетов: <span class="label label-success"><?=$statistics->countPaidPhysicalOrders;?></span></p>
    <p>На сумму: <span class="label label-warning"><?=$statistics->totalPhysical;?> руб.</span></p>
  </div>
</div>


<?if ($oldStatistics != null):?>
<h3>Старая(!!!) статистика по платежам</h3>
<div class="row indent-bottom3">
  <div class="span4">
    <h4 class="indent-bottom1">Юридические лица:</h4>
    <p>Выставлено счетов: <span class="label"><?=$oldStatistics->countJuridicalOrders;?></span></p>
    <p>Из них оплачено: <span class="label label-success"><?=$oldStatistics->countPaidJuridicalOrders;?></span></p>
    <p>На сумму: <span class="label label-warning"><?=$oldStatistics->totalJuridical;?> руб.</span></p>
  </div>
  <div class="span4 offset4">
    <h4 class="indent-bottom1">Физические лица:</h4>
    <p>Оплатили товаров: <span class="label label-success"><?=$oldStatistics->countPaidPhysicalOrders;?></span></p>
    <p>На сумму: <span class="label label-warning"><?=$oldStatistics->totalPhysical;?> руб.</span></p>
  </div>
</div>
<?endif;?>