<?php
/**
 * @var $form \competence\models\test\mailru2013_2\E5
 */
?>
<ul class="unstyled">
  <?foreach ($form->options as $key => $value):?>
    <li>
      <h4><?=$value;?></h4>
      <?=CHtml::activeDropDownList($form, 'value['.$key.']', $form->values, ['class' => 'span4']);?>
    </li>
  <?endforeach;?>
</ul>
