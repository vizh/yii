<?php
/**
 * @var \CController $this
 * @var \CActiveForm $activeForm
 * @var \user\models\forms\document\Passport $form
 * @var bool $submit
 */
\Yii::app()->getClientScript()->registerPackage('runetid.bootstrap-datepicker');
?>
<script type="text/javascript">
    $(function (){
        $('input[name*="Passport[DateIssue]"], input[name*="Passport[Birthday]"]').datepicker({
            format : 'dd.mm.yyyy',
            language : 'ru'
        });
    });
</script>
<div class="row-fluid">
    <div class="span5">
        <div class="control-group">
            <?=$activeForm->label($form, 'Series', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->textField($form, 'Series', ['class' => 'input-block-level'])?>
            </div>
        </div>
    </div>
    <div class="span7">
        <div class="control-group">
            <?=$activeForm->label($form, 'Number', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->textField($form, 'Number', ['class' => 'input-block-level'])?>
            </div>
        </div>
    </div>
</div>
<div class="control-group">
    <?=$activeForm->label($form, 'PlaceIssue', ['class' => 'control-label'])?>
    <div class="controls">
        <?=$activeForm->textArea($form, 'PlaceIssue', ['class' => 'input-block-level'])?>
    </div>
</div>
<div class="row-fluid">
    <div class="span4">
        <div class="control-group">
            <?=$activeForm->label($form, 'DateIssue', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->textField($form, 'DateIssue', ['class' => 'input-block-level'])?>
            </div>
        </div>
    </div>
    <div class="span4">
        <div class="control-group">
            <?=$activeForm->label($form, 'Authority', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->textField($form, 'Authority', ['class' => 'input-block-level'])?>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span4">
        <div class="control-group">
            <?=$activeForm->label($form, 'LastName', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->textField($form, 'LastName', ['class' => 'input-block-level'])?>
            </div>
        </div>
    </div>
    <div class="span4">
        <div class="control-group">
            <?=$activeForm->label($form, 'FirstName', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->textField($form, 'FirstName', ['class' => 'input-block-level'])?>
            </div>
        </div>
    </div>
    <div class="span4">
        <div class="control-group">
            <?=$activeForm->label($form, 'FatherName', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->textField($form, 'FatherName', ['class' => 'input-block-level'])?>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span4">
        <div class="control-group">
            <?=$activeForm->label($form, 'Birthday', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->textField($form, 'Birthday', ['class' => 'input-block-level'])?>
            </div>
        </div>
    </div>
    <div class="span8">
        <div class="control-group">
            <?=$activeForm->label($form, 'PlaceBirth', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->textField($form, 'PlaceBirth', ['class' => 'input-block-level'])?>
            </div>
        </div>
    </div>
</div>
<div class="control-group">
    <?=$activeForm->label($form, 'RegisteredAddress', ['class' => 'control-label'])?>
    <div class="controls">
        <?=$activeForm->textArea($form, 'RegisteredAddress', ['class' => 'input-block-level'])?>
    </div>
</div>
<div class="control-group">
    <?=$activeForm->label($form, 'ResidenceAddress', ['class' => 'control-label'])?>
    <div class="controls">
        <?=$activeForm->textArea($form, 'ResidenceAddress', ['class' => 'input-block-level'])?>
    </div>
</div>


