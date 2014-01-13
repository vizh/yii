<h2 class="indent-bottom3"><?=\Yii::t('app', 'Редактирование счета');?> №<?=$order->Id;?></h2>
<?if (\Yii::app()->getUser()->hasFlash('success')):?>
  <div class="alert alert-success"><?=\Yii::app()->getUser()->getFlash('success');?></div>
<?endif;?>
<?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>
<?=\CHtml::beginForm('', 'POST', ['class' => 'form-horizontal']);?>
<div class="control-group">
  <?=\CHtml::activeLabel($form, 'Name', ['class' => 'control-label']);?>
  <div class="controls">
    <?=\CHtml::activeTextField($form, 'Name', ['class' => 'input-xxlarge']);?>
  </div>
</div>
<div class="control-group">
  <?=\CHtml::activeLabel($form, 'Address', ['class' => 'control-label']);?>
  <div class="controls">
    <?=\CHtml::activeTextField($form, 'Address', ['class' => 'input-xxlarge']);?>
  </div>
</div>
<div class="control-group">
  <?=\CHtml::activeLabel($form, 'INN', ['class' => 'control-label']);?>
  <div class="controls">
    <?=\CHtml::activeTextField($form, 'INN', ['class' => 'input-xxlarge']);?>
  </div>
</div>
<div class="control-group">
  <?=\CHtml::activeLabel($form, 'KPP', ['class' => 'control-label']);?>
  <div class="controls">
    <?=\CHtml::activeTextField($form, 'KPP', ['class' => 'input-xxlarge']);?>
  </div>
</div>
<div class="control-group">
  <?=\CHtml::activeLabel($form, 'Phone', ['class' => 'control-label']);?>
  <div class="controls">
    <?=\CHtml::activeTextField($form, 'Phone', ['class' => 'input-xxlarge']);?>
  </div>
</div>
<div class="control-group">
  <?=\CHtml::activeLabel($form, 'PostAddress', ['class' => 'control-label']);?>
  <div class="controls">
    <?=\CHtml::activeTextField($form, 'PostAddress', ['class' => 'input-xxlarge']);?>
  </div>
</div>
<div class="control-group">
  <div class="controls">
    <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']);?>
  </div>
</div>
<?=\CHtml::endForm();?>

<div class="m-top_40">
<form method="POST">
<table id="order-items" class="table">
  <thead>
    <th><?=\Yii::t('app','Получатель');?></th>
    <th><?=\Yii::t('app','Товар');?></th>
    <th><?=\Yii::t('app','Цена');?></th>
    <th></th>
  </thead>
  <tbody>

  </tbody>
  <tfoot>
    <tr>
      <td>
        <input type="text" placeholder="<?=\Yii::t('app', 'Имя получателя');?>"/>
        <input type="hidden" name="RunetId" value=""/>
      </td>
      <td colspan="2">
        <?=\CHtml::dropDownList('ProductId', '', \CHtml::listData($products, 'Id', 'Title'), ['class' => 'input-xxlarge']);?>
      </td>
      <td style="padding-top: 11px;">
        <button class="btn btn-mini pull-right" type="submit"><?=\Yii::t('app', 'Добавить');?></button>
      </td>
    </tr>
  </tfoot>
</table>
</form>
</div>