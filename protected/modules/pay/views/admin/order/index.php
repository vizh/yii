<?php
/**
 * @var $form \partner\models\forms\OrderSearch
 * @var $orders \pay\models\Order[]
 * @var $paginator \application\components\utility\Paginator
 */
?>
<div class="row-fluid">

  <div class="span12">
    <?=CHtml::beginForm();?>
    <div class="row-fluid">
      <div class="span4">
        <?=CHtml::activeLabel($form, 'Order');?>
        <?=CHtml::activeTextField($form, 'Order', array('class' => 'span8'));?>
      </div>
      <div class="span4">
        <?=CHtml::activeLabel($form, 'Paid');?>
        <?=CHtml::activeDropDownList($form, 'Paid', $form->getListValues(), array('class' => 'span8'));?>
      </div>
      <div class="span4">
        <?=CHtml::activeLabel($form, 'Deleted');?>
        <?=CHtml::activeDropDownList($form, 'Deleted', $form->getListValues(), array('class' => 'span8'));?>
      </div>
    </div>

    <div class="row-fluid">
      <div class="span4">
        <?=CHtml::activeLabel($form, 'Company');?>
        <?=CHtml::activeTextField($form, 'Company', array('class' => 'span8'));?>
      </div>
      <div class="span4">
        <?=CHtml::activeLabel($form, 'INN');?>
        <?=CHtml::activeTextField($form, 'INN', array('class' => 'span8'));?>
      </div>
    </div>

    <div class="row-fluid">
      <div class="span4">
        <?=CHtml::activeLabel($form, 'Payer');?>
        <?=CHtml::activeTextField($form, 'Payer', array('placeholder' => 'RUNET-ID', 'class' => 'span8'));?>
      </div>
      <div class="offset4 span4">
        <button class="btn btn-large" type="submit"><i class="icon-search"></i> Искать</button>
      </div>
    </div>
    <?=CHtml::endForm();?>
  </div>

</div>

<div class="row-fluid">
  <div class="span12">
    <?if ($paginator->getCount() > 0):?>
      <table class="table table-striped relative-no-table">
        <thead>
        <tr>
          <th>Номер счета/заказа</th>
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
            <td data-title="Номер счета/заказа">
              <p class="lead" style="margin-bottom: 5px;"><?=$order->Number;?></p>
              <p class="muted"><?=$order->Id;?></p>
            </td>
            <td data-title="Краткие данные">
              <?if ($order->Type == \pay\models\OrderType::Juridical):?>
                <strong><?=$order->OrderJuridical->Name;?></strong><br>
                ИНН/КПП:&nbsp;<?=$order->OrderJuridical->INN;?> / <?=$order->OrderJuridical->KPP;?>
              <?elseif ($order->Type == \pay\models\OrderType::Receipt):?>
                <p class="text-warning"><strong>Квитанция</strong></p>
              <?else:?>
                <p class="text-warning"><strong>Через платежную систему</strong></p>
              <?endif;?>
            </td>
            <td data-title="Выставил">
              <?php echo $order->Payer->RunetId;?>, <strong><?php echo $order->Payer->getFullName();?></strong>
              <p>
                <em><?=$order->Payer->Email;?></em>
              </p>
              <?foreach ($order->Payer->LinkPhones as $link):?>
                <?if ($link->Phone == null) { continue; }?>
                <p><em><?=urldecode($link->Phone);?></em></p>
              <?endforeach;?>
            </td>
            <td data-title="Дата"><?=Yii::app()->locale->getDateFormatter()->format('d MMMM y', strtotime($order->CreationTime));?><br>
              <?if ($order->Paid):?>
                <span class="label label-success">ОПЛАЧЕН</span>
              <?else:?>
                <span class="label label-important">НЕ ОПЛАЧЕН</span>
              <?endif;?>
            </td>
            <td data-title="Сумма"><?=$order->getPrice();?> руб.</td>
            <td data-title="Управление">
              <?= \CHtml::beginForm(array('/pay/admin/order/view', 'orderId' => $order->Id)); ?>
                <div class="btn-group">
                  <a class="btn btn-info" href="<?=\Yii::app()->createUrl('/pay/admin/order/view', array('orderId' => $order->Id));?>"><i class="icon-list icon-white"></i></a>

                  <?if (!$order->Paid && $order->getIsBankTransfer()):?>
                    <button class="btn btn-success" type="submit" onclick="return confirm('Вы уверены, что хотите отметить данный счет оплаченным?');" name="SetPaid"><i class="icon-ok icon-white"></i></button>
                  <?else:?>
                    <button class="btn btn-success disabled" type="submit" disabled name="SetPaid"><i class="icon-ok icon-white"></i></button>
                  <?endif;?>

                  <?if ($order->Type == \pay\models\OrderType::Juridical):?>
                    <a class="btn" target="_blank" href="<?=$order->getUrl(true);?>"><i class="icon-print"></i></a>
                  <?else:?>
                    <a class="btn disabled" target="_blank"><i class="icon-print"></i></a>
                  <?endif;?>
                </div>
              <?= \CHtml::endForm(); ?>
            </td>
          </tr>
        <?endforeach;?>
        </tbody>

      </table>


      <?$this->widget('\application\widgets\Paginator', array('paginator' => $paginator));?>

    <?else:?>
      <div class="alert">
        <strong>Внимание!</strong> Нет ни одного счета с заданными параметрами.
      </div>
    <?endif;?>
  </div>
</div>

<div class="row-fluid">
  <div class="span12 indent-bottom3"></div>
</div>