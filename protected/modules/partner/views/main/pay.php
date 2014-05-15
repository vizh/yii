<?php
/**
 * @var \partner\controllers\main\PayStatistics $statistics
 * @var \partner\controllers\main\PayStatistics $oldStatistics
 * @var array $productStatistics
 */
?>
<style type="text/css">
  .label {font-size: 16px;}
</style>

<h1 class="indent-bottom3">Статистика по платежам</h1>

<div class="row indent-bottom2">
  <div class="span12">
    <table class="table table-bordered table-statistics">
      <thead>
      <tr>
        <td colspan="5" class="lead">
          <strong>Всего участников:</strong> <?=$statistics->countParticipants;?>
        </td>
      </tr>
      </thead>
      <tbody>
      <tr>
        <td class="span2">&nbsp;</td>
        <td class="span3">
          <h4 class="indent-bottom0">Юридические лица (счета)</h4>
        </td>
        <td class="span3">
          <h4 class="indent-bottom0">Физические лица (квитанции)</h4>
        </td>
        <td class="span3">
          <h4 class="indent-bottom0">Физические лица (онлайн)</h4>
        </td>
        <td class="span1"><h4 class="indent-bottom0">Итого</h4></td>
      </tr>

      <tr>
        <td>Выставлено:</td>
        <td><?=$statistics->countJuridicalOrders;?></td>
        <td><?=$statistics->countReceipts;?></td>
        <td><?=$statistics->countPaySystemOrders;?></td>
        <td><?=$statistics->getTotalOrders();?></td>
      </tr>
      <tr>
        <td>Не оплачено:</td>
        <td><span class="text-warning"><?=$statistics->countJuridicalOrders-$statistics->countPaidJuridicalOrders;?></span></td>
        <td><span class="text-warning"><?=$statistics->countReceipts-$statistics->countPaidReceipts;?></span></td>
        <td><span class="text-warning"><?=$statistics->countPaySystemOrders-$statistics->countPaidPaySystemOrders;?></span></td>
        <td><span class="text-warning"><?=$statistics->getTotalOrders() - $statistics->getTotalPaidOrders();?></span></td>
      </tr>
      <tr>
        <td>Оплачено:</td>
        <td><strong class="text-success"><?=$statistics->countPaidJuridicalOrders;?></strong></td>
        <td><strong class="text-success"><?=$statistics->countPaidReceipts;?></strong></td>
        <td><strong class="text-success"><?=$statistics->countPaidPaySystemOrders;?></strong></td>
        <td><strong class="text-success"><?=$statistics->getTotalPaidOrders();?></strong></td>
      </tr>

      <tr>
        <td>Людей включено:</td>
        <td><?=$statistics->countJuridicalUsers;?></td>
        <td><?=$statistics->countReceiptUsers;?></td>
        <td><?=$statistics->countPaySystemUsers;?></td>
        <td><?=$statistics->totalUsers;?></td>
      </tr>

      <tr>
        <td>Людей оплачено:</td>
        <td><strong class="text-success"><?=$statistics->countPaidJuridicalUsers;?></strong></td>
        <td><strong class="text-success"><?=$statistics->countPaidReceiptUsers;?></strong></td>
        <td><strong class="text-success"><?=$statistics->countPaidPaySystemUsers;?></strong></td>
        <td><strong class="text-success"><?=$statistics->totalPaidUsers;?></strong></td>
      </tr>

      <tr>
        <td colspan="4">Активировано 100% промо-кодов:</td>
        <td><?=$statistics->totalPromoUsers;?></td>
      </tr>

      <tr>
        <td>Сумма оплат:</td>
        <td>
          <span class="text-success lead"><?=number_format($statistics->totalJuridical, 0, ',', ' ');?> руб.</span>
        </td>
        <td>
          <span class="text-success lead"><?=number_format($statistics->totalReceipt, 0, ',', ' ');?> руб.</span>
        </td>
        <td>
          <span class="text-success lead"><?=number_format($statistics->totalPaySystem, 0, ',', ' ');?> руб.</span>
        </td>
        <td></td>
      </tr>

      </tbody>

      <tfoot>
      <tr>
        <td colspan="5"><strong class="text-success lead" style="font-size: 24px;">Итого: <?=number_format($statistics->getTotal(), 0, ',', ' ');?> руб.</strong></td>
      </tr>
      </tfoot>
    </table>
  </div>
  <div class="span12 indent-top3" style="font-size: 16px;">
    <strong>Количество запросивших счет/квитанцию:</strong>
    <?=$statistics->countJuridicalUsers + $statistics->countReceiptUsers - $statistics->countPaidJuridicalUsers - $statistics->countPaidReceiptUsers;?>
  </div>
</div>

<h3 class="indent-bottom2">Статистика проданных товаров</h3>

<div class="row indent-bottom2">
    <div class="span12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Количество</th>
            </tr>
            </thead>
            <tbody>
            <?foreach ($productStatistics as $row):?>
                <tr>
                    <td><?=$row['productId'];?></td>
                    <td><?=$row['title'];?></td>
                    <td><span class="lead"><?=$row['count'];?></span></td>
                </tr>
            <?endforeach;?>
            </tbody>
        </table>
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
    <p>Оплатили товаров: <span class="label label-success"><?=$oldStatistics->countPaidPaySystemOrders;?></span></p>
    <p>На сумму: <span class="label label-warning"><?=$oldStatistics->totalPaySystem;?> руб.</span></p>
  </div>
</div>
<?endif;?>