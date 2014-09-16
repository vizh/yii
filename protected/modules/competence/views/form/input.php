<?php
/**
 * @var $form \competence\models\form\Input
 */
?>
<ul class="unstyled">
  <li>
      <?if (empty($form->Suffix)):?>
          <?=CHtml::activeTextField($form, 'value', ['class' => 'input-block-level']);?>
      <?else:?>
          <div class="input-append">
              <?=CHtml::activeTextField($form, 'value', ['class' => 'span8']);?>
              <span class="add-on"><?=$form->Suffix;?></span>
          </div>
      <?endif;?>
  </li>
</ul>