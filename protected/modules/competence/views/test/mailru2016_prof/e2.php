<?php
/**
 * @var $form \competence\models\test\mailru2016_prof\E2
 */
?>
<ul class="unstyled">
  <?foreach($form->getValues() as $value):?>
    <li>
        <h4><?=$value->title?></h4>
      <?=CHtml::activeDropDownList($form, 'value['.$value->key.']', $form->options, ['class' => 'span4'])?>
    </li>
  <?endforeach?>
</ul>