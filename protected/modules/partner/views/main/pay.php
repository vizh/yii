<style type="text/css">
  .label {font-size: 16px;}
</style>

<h1 class="indent-bottom3">Статистика по платежам</h1>
<div class="row indent-bottom3">
  <div class="span4">
    <h2 class="indent-bottom1">Юридические лица:</h2>
    <p>Выставлено счетов: <span class="label"><?php echo $stat->Juridical->Orders;?></span></p>
    <p>Из них оплачено: <span class="label label-success"><?php echo $stat->Juridical->OrdersPaid;?></span></p>
    <p>На сумму: <span class="label label-warning"><?php echo $stat->Juridical->Total;?> руб.</span></p>
  </div>
  <div class="span4 offset4">
    <h2 class="indent-bottom1">Физические лица:</h2>
    <p>Оплатили: <span class="label label-success"><?php echo $stat->Individual->Paid;?></span></p>
    <p>На сумму: <span class="label label-warning"><?php echo $stat->Individual->Total;?> руб.</span></p>
  </div>
</div>