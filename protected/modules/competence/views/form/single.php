<?php
/**
 * @var $form \competence\models\form\Single
 */
?>
<ul class="unstyled">
  <?foreach ($form->Values as $value):?>
    <li>
      <label class="radio">
        <?=CHtml::activeRadioButton($form, 'value', ['value' => $value->key, 'uncheckValue' => null, 'data-group' => $form->getQuestion()->Code, 'data-target' => '#'.$form->getQuestion()->Code.'_'.$value->key]);?>
        <?=$value->title;?>
      </label>
      <?if ($value->isOther):?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <?if (empty($value->suffix)):?>
          <?=CHtml::activeTextField($form, 'other', ['class' => 'span4', 'data-group' => $form->getQuestion()->Code, 'id' => $form->getQuestion()->Code.'_'.$value->key]);?>
          <?else:?>
              <div class="input-append">
                  <?=CHtml::activeTextField($form, 'other', ['class' => 'span4', 'data-group' => $form->getQuestion()->Code, 'id' => $form->getQuestion()->Code.'_'.$value->key]);?>
                  <span class="add-on"><?=$value->suffix;?></span>
              </div>
          <?endif;?>
      <?endif;?>
    </li>
  <?endforeach;?>
</ul>