<?php
/**
 * @var $orders Order[]
 * @var $count int
 * @var $filter string
 * @var $perPage int
 * @var $page int
 */
?>
<div class="row">
  <div class="span12 indent-bottom3">
    <h2><?=$filter == 'active' ? 'Активированные счета' :'Неактивированные счета'?></h2>
  </div>
  <div class="span12">
    <?if ($count > 0):?>
    <table class="table table-striped">
      <thead>
      <tr>
        <th>Cчет</th>
        <th>Краткие данные</th>
        <th>Выставил</th>
        <th>Дата</th>
        <th>Сумма</th>
        <th>Управление</th>
      </tr>
      </thead>

      <tbody>
        <?foreach ($orders as $order):?>
      <tr>
        <td><h3><?=$order->OrderId;?></h3></td>
        <td width="35%">
          <strong><?=$order->OrderJuridical->Name;?></strong><br>
          ИНН/КПП:&nbsp;<?=$order->OrderJuridical->INN;?>&nbsp;/&nbsp;<?=$order->OrderJuridical->KPP;?>
        </td>
        <td>
            <?php echo $order->Payer->RocId;?>, <strong><?php echo $order->Payer->GetFullName();?></strong>
            <p>
                <em><?php echo $order->Payer->GetEmail() !== null ? $order->Payer->GetEmail()->Email : $order->Payer->Email; ?></em>
            </p>
            <?php if (!empty($order->Payer->Phones)):?>
                <p><em><?php echo urldecode($order->Payer->Phones[0]->Phone);?></em></p>
            <?php endif;?>
        </td>
        <td><?=Yii::app()->locale->getDateFormatter()->format('d MMMM y', strtotime($order->CreationTime));?></td>
        <td><?=$order->Price();?> руб.</td>
        <td>
          <a class="btn btn-info" href="<?=\Yii::app()->createUrl('/partner/order/view', array('orderId' => $order->OrderId));?>"><i class="icon-search icon-white"></i> Просмотр</a>
        </td>
      </tr>
        <?endforeach;?>
      </tbody>

    </table>


    <?else:?>
    <div class="alert">
      <strong>Внимание!</strong> У вас нет ни одного выставленного счета.
    </div>
    <?endif;?>
  </div>

  <div class="span12 indent-bottom3">
    <?php
    $this->widget('\application\widgets\Paginator', array(
      'url' => '/partner/order/index',
      'count' => $count,
      'perPage' => $perPage,
      'page' => $page
    ));
    ?>
  </div>
  <div class="span12 indent-bottom3">
  </div>
</div>