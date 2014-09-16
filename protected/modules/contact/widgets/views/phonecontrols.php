<?php
/**
 * @var \contact\widgets\PhoneControls $this
 */

$class = $this->inputClass;
if ($this->form->hasErrors()) {
    $class .= ' ' . $this->errorClass;
}
?>

<div class="widget-phone-controls">
  <div class="controls">
      <?=\CHtml::activeTextField($this->form, $this->name, ['class' => $class, 'placeholder' => $this->placeholder !== null ? Yii::t('app', $this->placeholder) : '', 'disabled' => $this->disabled]);?>
  </div>
</div>