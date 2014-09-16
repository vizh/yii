<?php
/**
 * @var \competence\models\Question $question
 */

/** @var \competence\models\form\Textarea $form */
$form = $question->getForm();
$form->Required = $form->Required !== null ? $form->Required : true;
?>
<div class="control-group">

    <div class="controls">
        <label class="checkbox"><?=CHtml::activeCheckBox($form, 'Required', ['uncheckValue' => null]);?> <?=$form->getAttributeLabel('Required');?></label>
    </div>
</div>