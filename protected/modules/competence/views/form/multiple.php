<?php
/**
 * @var $form \competence\models\form\Multiple
 */
?>
<ul class="unstyled">
  <?foreach ($form->Values as $value):?>
    <li>
      <label class="checkbox">
        <?=CHtml::activeCheckBox($form, 'value', ['value' => $value->key, 'uncheckValue' => null, 'data-group' => $form->getQuestion()->Code, 'data-target' => '#'.$form->getQuestion()->Code.'_'.$value->key]);?>
        <?=$value->title;?>
      </label>
      <?if ($value->isOther):?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=CHtml::activeTextField($form, 'other', ['class' => 'span4', 'data-group' => $form->getQuestion()->Code, 'id' => $form->getQuestion()->Code.'_'.$value->key]);?>
      <?endif;?>
    </li>
  <?endforeach;?>
</ul>