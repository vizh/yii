<?php
/**
 * @var $form \partner\models\forms\OrderItemSearch
 * @var $products \pay\models\Product[]
 * @var $orderItems \pay\models\OrderItem[]
 * @var $paySystemStat array
 * @var $paginator \application\components\utility\Paginator
 */
?>
<div class="row">
  <div class="span12">
    <?=CHtml::beginForm();?>
    <div class="row">
      <div class="span4">
        <?=CHtml::activeLabel($form, 'OrderItem');?>
        <?=CHtml::activeTextField($form, 'OrderItem');?>
      </div>
      <div class="span4">
        <?=CHtml::activeLabel($form, 'Order');?>
        <?=CHtml::activeTextField($form, 'Order');?>
      </div>
      <div class="span4">
        <?=CHtml::activeLabel($form, 'Product');?>
        <?=CHtml::activeTextField($form, 'Product');?>
      </div>
    </div>

    <div class="row">
      <div class="span4">
        <?=CHtml::activeLabel($form, 'Payer');?>
        <?=CHtml::activeTextField($form, 'Payer', array('placeholder' => 'RUNET-ID'));?>
      </div>
      <div class="span4">
        <?=CHtml::activeLabel($form, 'Owner');?>
        <?=CHtml::activeTextField($form, 'Owner', array('placeholder' => 'RUNET-ID'));?>
      </div>
    </div>

    <div class="row">
      <div class="span4">
        <?=CHtml::activeLabel($form, 'Paid');?>
        <?=CHtml::activeDropDownList($form, 'Paid', $form->getListValues());?>
      </div>
      <div class="span4">
        <?=CHtml::activeLabel($form, 'Deleted');?>
        <?=CHtml::activeDropDownList($form, 'Deleted', $form->getListValues());?>
      </div>
      <div class="span4">
        <button class="btn btn-large" type="submit"><i class="icon-search"></i> Искать</button>
      </div>
    </div>
    <?=CHtml::endForm();?>
  </div>
</div>

<script type="text/javascript">
  $(function () {
    $('.table a.btn-activation').click( function (e) {
      var msg = 'Вы точно хотите '+ ( $(e.currentTarget).hasClass('btn-success') ? 'активировать' : 'деактивировать') + ' оплату'
      if ( confirm (msg)) {
        $.post('/orderitem/activateajax/', {
          'action'      : $(e.currentTarget).hasClass('btn-success') ? 'activate' : 'deactivate',
          'orderItemId' : $(e.currentTarget).data('orderitemid')
        }, 
        function (response) {
          if (response.success) {
            window.location.reload();
          }
          else {
            alert('Произошла ошибка при активации!');
          }
        }, 'json');
      }
      return false;
    });
  });
</script>
<?if (!empty($orderItems)):?>
<div class="row">
  <div class="span12">
    <table class="table table-striped">
      <thead>
      <tr>
      <th>Дата</th>
      <th>Товар</th>
      <th>Сумма</th>
      <th>Тип&nbsp;оплаты</th>
      <th>Плательщик</th>
      <th>Получатель</th>
      <!--<th>Активация</th>-->
      </tr>
      </thead>
      <tbody>
        <?foreach ($orderItems as $orderItem):?>
      <tr>
        <td><small><?=$orderItem->CreationTime?></small></td>
        <td><?=$orderItem->Product->Title;?></td>
        <td>
          <?=$orderItem->getPriceDiscount();?>&nbsp;руб.<br/>
          <?if ($orderItem->Paid):?>
          <span class="label label-success">Оплачен</span>
          <?else:?>
          <span class="label">Не оплачен</span>
          <?endif;?>

          <?if ($orderItem->Deleted):?>
          <span class="label label-warning">Удален</span>
          <?endif;?>
        </td>
        <td>
          <?if (!empty($paySystemStat[$orderItem->Id])):?>
              <?if ($paySystemStat[$orderItem->Id] == 'Juridical'):?>
              <span class="text-info">Юр. счет</span>
              <?elseif (strpos($paySystemStat[$orderItem->Id], 'pay\components\systems\\') !== false):?>
              <span class="text-warning"><?=str_replace('pay\components\systems\\', '', $paySystemStat[$orderItem->Id]);?></span>
              <?else:?>
              <span class="muted">Не задан</span>
              <?endif;?>
          <?else:?>
            <span class="muted">Не задан</span>
          <?endif;?>
        </td>
        <td>
          <?=$orderItem->Payer->RunetId;?>, <strong><?=$orderItem->Payer->getFullName();?></strong>
          <p><em><?=$orderItem->Payer->Email;?></em></p>
        </td>
        <td>
          <?=$orderItem->Owner->RunetId;?>, <strong><?=$orderItem->Owner->getFullName();?></strong>
          <p><em><?=$orderItem->Owner->Email;?></em></p>
          
          <?if ($orderItem->ChangedOwner !== null):?>
            <p class="text-success"><strong>Перенесено на пользователя</strong></p>
            <?=$orderItem->ChangedOwner->RunetId;?>, <strong><?=$orderItem->ChangedOwner->getFullName();?></strong>
            <p><em><?=$orderItem->ChangedOwner->Email; ?></em></p>
          <?endif;?>
        </td>
        <td>
          <?if ($this->getAccessFilter()->checkAccess('partner', 'orderitem', 'activateajax')):?>
            <?if ($orderItem->Paid && !$orderItem->Deleted):?>
              <a href="#" class="btn btn-danger btn-mini btn-activation indent-bottom1" data-orderitemid="<?=$orderItem->Id;?>">Деактивировать</a>
            <?else:?>
              <a href="#" class="btn btn-success btn-mini btn-activation indent-bottom1" data-orderitemid="<?=$orderItem->Id;?>">Активировать</a>
            <?endif;?>
          <?endif;?>
          
          <?if ($this->getAccessFilter()->checkAccess('partner', 'orderitem', 'redirect')
            && $orderItem->Paid):?>
            <a href="<?=$this->createUrl('orderitem/redirect', array('OrderItemId' => $orderItem->Id));?>" class="btn btn-mini">Перенос</a>
          <?endif;?>
        </td>
      </tr>
        <?endforeach;?>
      </tbody>
    </table>
  </div>
</div>
<?else:?>
<div class="alert">По Вашему запросу заказов не найдено.</div>
<?endif;?>

<?$this->widget('\application\widgets\Paginator', array('paginator' => $paginator));?>