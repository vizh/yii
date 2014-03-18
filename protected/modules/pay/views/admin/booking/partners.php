<div class="btn-toolbar">

</div>
<div class="well">
  <table class="table">
    <thead>
      <th><?=\Yii::t('app', 'Партнер');?></th>
      <th><?=\Yii::t('app', 'Всего');?></th>
      <th><?=\Yii::t('app', 'Оплачено');?></th>
      <th><?=\Yii::t('app', 'Не оплачено');?></th>
      <th></th>
    </thead>
    <tbody>
      <?foreach ($results as $result):?>
      <tr>
        <td><strong><?=$result->Partner;?></strong></td>
        <td><?=$result->Ordered;?></td>
        <td class="text-success"><?=$result->Paid;?></td>
        <td><?=$result->Ordered-$result->Paid;?></td>
        <td style="width: 1px;"><a href="<?=$this->createUrl('/pay/admin/booking/partner', ['owner' => $result->Partner]);?>" class="btn btn-info"><?=\Yii::t('app', 'Редактировать');?></a></td>
      </tr>
      <?endforeach;?>
    </tbody>
  </table>
</div>