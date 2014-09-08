<?php
/**
 * @var A6 $form
 */
use competence\models\test\runet2014\A6;

?>
<div class="form-horizontal">
    <div class="control-group">
        <?=CHtml::activeLabel($form, 'work_phone', ['class' => 'control-label']);?>
        <div class="controls">
            <?=CHtml::activeTextField($form, 'work_phone');?>
        </div>
    </div>
    <div class="control-group">
        <?=CHtml::activeLabel($form, 'mobile_phone', ['class' => 'control-label']);?>
        <div class="controls">
            <?=CHtml::activeTextField($form, 'mobile_phone');?>
        </div>
    </div>
    <div class="control-group">
        <?=CHtml::activeLabel($form, 'work_email', ['class' => 'control-label']);?>
        <div class="controls">
            <?=CHtml::activeTextField($form, 'work_email');?>
        </div>
    </div>
    <div class="control-group">
        <?=CHtml::activeLabel($form, 'main_email', ['class' => 'control-label']);?>
        <div class="controls">
            <?=CHtml::activeTextField($form, 'main_email');?>
        </div>
    </div>
    <div class="control-group">
        <?=CHtml::activeLabel($form, 'additional_email', ['class' => 'control-label']);?>
        <div class="controls">
            <?=CHtml::activeTextField($form, 'additional_email');?>
        </div>
    </div>
</div>
