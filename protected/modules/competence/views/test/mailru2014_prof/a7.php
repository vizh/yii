<?php
/**
 * @var $form \competence\models\test\mailru2013_2\A7
 */
?>
<ul class="unstyled company-interest-list">
  <?foreach ($form->getOptions() as $key => $value):?>
  <li>
    <h4><strong><?=$value;?></strong></h4>
    <ul class="unstyled ib3">
    <?foreach ($form->values as $key_1 => $value_1):?>
      <li>
        <label class="checkbox">
          <?=CHtml::activeCheckBox($form, 'value['.$key.'][]', array('value' => $key_1, 'uncheckValue' => null, 'checked' => isset($form->value[$key]) && in_array($key_1, $form->value[$key]), 'data-group' => 'group'.$key, 'data-unchecker' => (int)($key_1==9)));?>
          <?=$value_1;?>
        </label>
      </li>
    <?endforeach;?>
    </ul>
  </li>
  <?endforeach;?>
</ul>