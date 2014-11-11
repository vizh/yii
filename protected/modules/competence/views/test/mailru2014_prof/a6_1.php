<?php
/**
 * @var $form \competence\models\test\mailru2013_2\A6_1
 */

$e1Result = $form->getE1Result();
?>

<ul class="unstyled">
  <?foreach ($form->getOptions() as $key => $value):?>
  <li>
    <h4><strong><?=$value;?></strong></h4>
    <ul class="unstyled ib4">
    <?foreach ($form->values as $key_1 => $value_1):
      if ($key_1 == 10 && empty($e1Result['other']))
      {
        continue;
      }
      ?>
      <li>
        <label class="checkbox">
          <?=CHtml::activeCheckBox($form, 'value['.$key.'][]', array('value' => $key_1, 'uncheckValue' => null, 'checked' => isset($form->value[$key]) && in_array($key_1, $form->value[$key])));?>
          <?if ($key_1 != 10):?>
          <?=$value_1;?>
          <?else:?>
          Другое (<em>добавлен свой вариант</em>: <strong><?=$e1Result['other'];?></strong>)
          <?endif;?>
        </label>
      </li>
    <?endforeach;?>
    </ul>
  </li>
  <?endforeach;?>
</ul>