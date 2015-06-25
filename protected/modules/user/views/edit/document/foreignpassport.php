<?php
/**
 * @var \CController $this
 * @var \CActiveForm $activeForm
 * @var \user\models\forms\document\ForeignPassport $form
 */

?>
<?php $activeForm = $this->beginWidget('CActiveForm');?>
<?=$activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>');?>
<div class="row-fluid">
    <div class="span1">
        <div class="control-group">
            <?=$activeForm->label($form, 'Type', ['class' => 'control-label']);?>
            <div class="controls">
                <?=$activeForm->textField($form, 'Type', ['class' => 'input-block-level']);?>
            </div>
        </div>
    </div>
    <div class="span3">
        <div class="control-group">
            <?=$activeForm->label($form, 'CountryCode', ['class' => 'control-label']);?>
            <div class="controls">
                <?=$activeForm->textField($form, 'CountryCode', ['class' => 'input-block-level']);?>
            </div>
        </div>
    </div>
    <div class="span8">
        <div class="control-group">
            <?=$activeForm->label($form, 'Number', ['class' => 'control-label']);?>
            <div class="controls">
                <?=$activeForm->textField($form, 'Number', ['class' => 'input-block-level']);?>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <?=$activeForm->label($form, 'FirstName', ['class' => 'control-label']);?>
            <div class="controls">
                <?=$activeForm->textField($form, 'FirstName', ['class' => 'input-block-level']);?>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <?=$activeForm->label($form, 'LastName', ['class' => 'control-label']);?>
            <div class="controls">
                <?=$activeForm->textField($form, 'LastName', ['class' => 'input-block-level']);?>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <?=$activeForm->label($form, 'Nationality', ['class' => 'control-label']);?>
            <div class="controls">
                <?=$activeForm->textField($form, 'Nationality', ['class' => 'input-block-level']);?>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <?=$activeForm->label($form, 'PersonalNumber', ['class' => 'control-label']);?>
            <div class="controls">
                <?=$activeForm->textField($form, 'PersonalNumber', ['class' => 'input-block-level']);?>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span4">
        <div class="control-group">
            <?=$activeForm->label($form, 'Birthday', ['class' => 'control-label']);?>
            <div class="controls">
                <?=$activeForm->textField($form, 'Birthday', ['class' => 'input-block-level', 'placeholder' => \Yii::t('app', 'Пример: 01.01.1980')]);?>
            </div>
        </div>
    </div>
    <div class="span8">
        <div class="control-group">
            <?=$activeForm->label($form, 'PlaceBirth', ['class' => 'control-label']);?>
            <div class="controls">
                <?=$activeForm->textField($form, 'PlaceBirth', ['class' => 'input-block-level']);?>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span4">
        <div class="control-group">
            <?=$activeForm->label($form, 'DateIssue', ['class' => 'control-label']);?>
            <div class="controls">
                <?=$activeForm->textField($form, 'DateIssue', ['class' => 'input-block-level', 'placeholder' => \Yii::t('app', 'Пример: 01.01.1980')]);?>
            </div>
        </div>
    </div>
    <div class="span4">
        <div class="control-group">
            <?=$activeForm->label($form, 'Authority', ['class' => 'control-label']);?>
            <div class="controls">
                <?=$activeForm->textField($form, 'Authority', ['class' => 'input-block-level']);?>
            </div>
        </div>
    </div>
    <div class="span4">
        <div class="control-group">
            <?=$activeForm->label($form, 'DateExpire', ['class' => 'control-label']);?>
            <div class="controls">
                <?=$activeForm->textField($form, 'DateExpire', ['class' => 'input-block-level', 'placeholder' => \Yii::t('app', 'Пример: 01.01.1980')]);?>
            </div>
        </div>
    </div>
</div>
<div class="form-footer">
    <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-info']);?>
</div>
<?php $this->endWidget();?>

