<?php
/**
 * @var \competence\models\Question $question
 */

/** @var \competence\models\form\Input $form */
$form = $question->getForm();
$form->Required = $form->Required !== null ? $form->Required : true;
?>
<div class="control-group">
    <?=CHtml::activeLabel($form, 'Suffix', ['class' => 'control-label']);?>
    <div class="controls">
        <?=CHtml::activeTextField($form, 'Suffix');?>
    </div>
</div>

<div class="control-group">
    <div class="controls">
        <label class="checkbox"><?=CHtml::activeCheckBox($form, 'Required', ['uncheckValue' => null]);?> <?=$form->getAttributeLabel('Required');?></label>
    </div>
</div>