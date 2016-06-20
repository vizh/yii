<?php
/**
 * @var $form \partner\models\forms\OrderSearch
 * @var $orders \pay\models\Order[]
 * @var $paginator \application\components\utility\Paginator
 */
?>

<?=CHtml::beginForm();?>

  <div class="row-fluid">

    <div class="span8">

      <div class="row-fluid">
        <div class="span6">
          <?=CHtml::activeLabel($form, 'Order');?>
          <?=CHtml::activeTextField($form, 'Order', array('class' => 'span12'));?>
        </div>
        <div class="span6">
          <?=CHtml::activeLabel($form, 'Payer');?>
          <?=CHtml::activeTextField($form, 'Payer', array('placeholder' => 'RUNET-ID', 'class' => 'span12'));?>
        </div>
      </div>

      <div class="row-fluid">
        <?=CHtml::activeLabel($form, 'Company');?>
        <?php $this->widget('\application\widgets\AutocompleteInput', [
          'model' => $form,
          'attribute' => 'Company',
          'label' => $form->Company,
          'htmlOptions' => ['class' => 'span12'],
          'source' => $this->createUrl('autocomplete'),
        ]); ?>
      </div>

    </div>

    <div class="span3 offset1">

      <div class="row form-inline">
        <?=CHtml::activeCheckBox($form, 'Deleted');?>
        <?=CHtml::activeLabel($form, 'Deleted');?>
      </div>

      <div class="row form-inline">
        <?=CHtml::activeCheckBox($form, 'Paid');?>
        <?=CHtml::activeLabel($form, 'Paid');?>
      </div>

      <div class="row">
        <button class="btn btn-large" type="submit"><i class="icon-search"></i> Искать</button>
      </div>

    </div>

  </div>
<?=CHtml::endForm();?>

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
          <?php $this->renderPartial('row', ['order' => $order]); ?>
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