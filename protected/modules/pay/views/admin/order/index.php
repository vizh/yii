<?php
/**
 * @var $form \partner\models\forms\OrderSearch
 * @var $orders \pay\models\Order[]
 * @var $paginator \application\components\utility\Paginator
 */
?>

<?=CHtml::beginForm()?>
  <div class="row-fluid" style="margin-top:1em">
    <div class="span8">
      <div class="span6">
        <?=CHtml::activeLabel($form, 'Order')?>
        <?=CHtml::activeTextField($form, 'Order', ['class' => 'span12'])?>
      </div>
      <div class="span6">
        <?=CHtml::activeLabel($form, 'Payer')?>
        <?=CHtml::activeTextField($form, 'Payer', ['placeholder' => 'RUNET-ID', 'class' => 'span12'])?>
      </div>
    </div>
    <div class="span3 offset1">
      <div class="row form-inline">
        <?=CHtml::activeCheckBox($form, 'Deleted')?>
        <?=CHtml::activeLabel($form, 'Deleted')?>
      </div>
      <div class="row form-inline">
        <?=CHtml::activeCheckBox($form, 'Paid')?>
        <?=CHtml::activeLabel($form, 'Paid')?>
      </div>
    </div>
  </div>
  <div class="row-fluid">
    <div class="span8">
      <?=CHtml::activeLabel($form, 'Company')?>
      <?=CHtml::activeTextField($form, 'Company', ['placeholder' => '', 'class' => 'span12'])?>
    </div>
    <div class="span3 offset1">
      <button class="btn btn-large" type="submit" style="margin-top:10px"><i class="icon-search"></i> Искать</button>
    </div>
  </div>
<?=CHtml::endForm()?>

<div class="row-fluid">
  <div class="span12">
    <?if($paginator->getCount() > 0):?>
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
        <?foreach($orders as $order):?>
          <?$this->renderPartial('row', ['order' => $order])?>
        <?endforeach?>
        </tbody>

      </table>


      <?$this->widget('\application\widgets\Paginator', array('paginator' => $paginator))?>

    <?else:?>
      <div class="alert">
        <strong>Внимание!</strong> Нет ни одного счета с заданными параметрами.
      </div>
    <?endif?>
  </div>
</div>

<div class="row-fluid">
  <div class="span12 indent-bottom3"></div>
</div>