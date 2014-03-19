<div class="btn-toolbar"></div>
<div class="well">
  <table class="table table-bordered">
    <thead>
      <tr>
        <?foreach ($statistics->Numbers as $stat):?>
          <th colspan="3" class="text-center">
            <?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $stat->DateFrom);?> &mdash; <?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $stat->DateTo);?>
          </th>
        <?endforeach;?>
      </tr>
      <tr>
        <?foreach ($statistics->Numbers as $stat):?>
          <th class="text-center"><?=\Yii::t('app', 'Забронировано');?></th>
          <th class="text-center"><?=\Yii::t('app', 'Оплачено');?></th>
          <th class="text-center"><?=\Yii::t('app', 'Свободно');?></th>
        <?endforeach;?>
      </tr>
    </thead>
    <tbody>
      <tr>
      <?foreach ($statistics->Numbers as $stat):?>
        <td class="text-center text-warning"><?=$stat->Booking;?></td>
        <td class="text-center text-success"><?=$stat->Paid;?></td>
        <td class="text-center text-info"><?=$stat->Free;?></td>
      <?endforeach;?>
      </tr>
    </tbody>
  </table>
  <div class="row-fluid m-top_40">
    <div class="span3">
      <?=\Yii::t('app', 'Забронировано номеров на сумму');?>: <span class="label label-warning"><?=$statistics->TotalBookPrice;?> <?=\Yii::t('app', 'руб');?>.</span>
    </div>
    <div class="span3">
      <?=\Yii::t('app', 'Оплачено номеров на сумму');?>: <span class="label label-success"><?=$statistics->TotalPaidPrice;?> <?=\Yii::t('app', 'руб');?>.</span>
    </div>
  </div>
</div>