<?php
/**
 * @var \pay\components\OrderItemCollection|\pay\components\OrderItemCollectable[] $collection
 * @var \pay\models\forms\Juridical $form
 */
?>
<?=CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>

<div class="row">
  <div class="span12 indent-bottom2">
    <h2>Выставление счета для <?=$this->action->payer->GetFullName();?></h2>
  </div>
</div>
<div class="row">
  <div class="span12 indent-bottom3">
    <table class="table table-striped table-bordered">
      <tr>
        <th>Получатель</th>
        <th>Товар</th>
        <th>Цена</th>
      </tr>

      <?foreach ($collection as $item):?>
        <tr>
          <td><?=$item->getOrderItem()->Owner->GetFullName();?></td>
          <td><?=$item->getOrderItem()->Product->Title;?></td>
          <td><?=$item->getPriceDiscount();?> руб.</td>
        </tr>
      <?endforeach;?>
    </table>
  </div>
</div>

<div class="row">
  <div class="span12">
    <?=CHtml::beginForm('', 'post', array('class' => 'form-horizontal m-top_40'));?>

    <div class="control-group">
      <?=CHtml::activeLabel($form, 'Name', array('class' => 'control-label'));?>
      <div class="controls">
        <?=CHtml::activeTextField($form, 'Name', array('class' => 'span6'));?>
      </div>
    </div>
    <div class="control-group">
      <?=CHtml::activeLabel($form, 'Address', array('class' => 'control-label'));?>
      <div class="controls">
        <?=CHtml::activeTextArea($form, 'Address', array('class' => 'span6'));?>
      </div>
    </div>
    <div class="control-group">
      <?=CHtml::activeLabel($form, 'INN', array('class' => 'control-label'));?>
      <div class="controls">
        <?=CHtml::activeTextField($form, 'INN', array('class' => 'span6'));?>
      </div>
    </div>
    <div class="control-group">
      <?=CHtml::activeLabel($form, 'KPP', array('class' => 'control-label'));?>
      <div class="controls">
        <?=CHtml::activeTextField($form, 'KPP', array('class' => 'span6'));?>
      </div>
    </div>
    <div class="control-group">
      <?=CHtml::activeLabel($form, 'Phone', array('class' => 'control-label'));?>
      <div class="controls">
        <?=CHtml::activeTextField($form, 'Phone', array('class' => 'span6'));?>
      </div>
    </div>
    <div class="control-group">
      <?=CHtml::activeLabel($form, 'PostAddress', array('class' => 'control-label'));?>
      <div class="controls">
        <?=CHtml::activeTextArea($form, 'PostAddress', array('class' => 'span6'));?>
      </div>
    </div>

    <div class="control-group">
      <div class="controls">
        <div class="row">
          <div class="span3 offset4">
            <button type="submit" class="btn btn-info"><?=\Yii::t('app', 'Выставить счет')?></button>
          </div>
        </div>
      </div>
    </div>

    <?php echo CHtml::endForm();?>
  </div>
</div>
