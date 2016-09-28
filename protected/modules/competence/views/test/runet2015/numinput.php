<?php
/**
 * @var $form \competence\models\form\Input
 */
?>
<ul class="unstyled">
  <li>
      <div class="input-append">
          <?=CHtml::activeTextField($form, 'value', ['class' => 'span2'])?>
          <span class="add-on"><?=$form->Suffix?></span>
      </div>
  </li>
</ul>