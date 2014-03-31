<?
/**
 * @var OrderController $this
 * @var \pay\models\forms\Juridical $form
 */
?>

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