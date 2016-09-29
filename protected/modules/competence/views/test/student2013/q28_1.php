<?php
/**
 * @var $form \competence\models\test\student2013\Q28_1
 */
?>
<?foreach($form->getRows() as $keyTop => $valueTop):?>
  <h4 class="company-large-list"><em><?=$valueTop?></em></h4>

  <div class="row ib3">
    <?foreach($form->getOptions() as $key => $value):?>
      <div class="span3">
        <label class="radio">
          <?=CHtml::activeRadioButton($form, 'value['.$keyTop.']', array('value' => $key, 'uncheckValue' => null, 'checked' => isset($form->value[$keyTop]) && $form->value[$keyTop] == $key, 'data-unchecker' => 1, 'data-unchecker-group' => 'group'.$keyTop, 'data-unchecker-negative' => (int)($key==90)))?>
          <?=$value?>
        </label>
      </div>
    <?endforeach?>
  </div>
<?endforeach?>