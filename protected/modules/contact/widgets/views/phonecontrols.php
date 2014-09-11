<?php
/**
 * @var \contact\widgets\PhoneControls $this
 */

$class =  $this->inputClass != null ? $this->inputClass : 'input-block-level';
if ($this->form->hasErrors())
    $class .= ' error';
?>

<div class="widget-phone-controls">
  <div class="controls">
      <?=\CHtml::activeTextField($this->form, 'OriginalPhone', ['class' => $class, 'placeholder' => \Yii::t('app', 'Номер телефона'), 'disabled' => $this->disabled]);?>
  </div>
</div>