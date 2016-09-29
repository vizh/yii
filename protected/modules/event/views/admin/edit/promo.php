<?php
/**
 * @var \application\components\controllers\AdminMainController $this
 * @var \event\models\forms\admin\Promo $form
 * @var \application\widgets\ActiveForm $activeForm
 */

/** @var \CClientScript $clientScript */
$clientScript = \Yii::app()->getClientScript();
$clientScript->registerPackage('runetid.jquery.colpick');
?>

<div class="btn-toolbar">
    <?=\CHtml::link(('<i class="icon-arrow-left"></i> ' . \Yii::t('app', 'Назад')), ['index', 'eventId' => $form->getActiveRecord()->Id], ['class' => 'btn'])?>
</div>
<div class="well">
    <?$this->widget('\event\widgets\Promo', ['event' => $form->getActiveRecord()])?>

    <?$activeForm = $this->beginWidget('\application\widgets\ActiveForm', ['htmlOptions' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data']])?>
    <?=$activeForm->errorSummary($form, '<div class="alert alert-error">')?>
    <div class="control-group">
        <?=$activeForm->label($form, 'BackgroundImage', ['class' => 'control-label'])?>
        <div class="controls">
            <?=$activeForm->fileField($form, 'BackgroundImage')?>
        </div>
    </div>
    <div class="control-group">
        <?=$activeForm->label($form, 'BackgroundColor', ['class' => 'control-label'])?>
        <div class="controls">
            <div class="input-prepend">
                <span class="add-on">#</span>
                <?=$activeForm->textField($form, 'BackgroundColor')?>
            </div>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <label class="checkbox">
                <?=$activeForm->checkBox($form, 'BackgroundNoRepeat')?> <?=$form->getAttributeLabel('BackgroundNoRepeat')?>
            </label>
        </div>
    </div>
    <div class="control-group">
        <?=$activeForm->label($form, 'TitleColor', ['class' => 'control-label'])?>
        <div class="controls">
            <div class="input-prepend">
                <span class="add-on">#</span>
                <?=$activeForm->textField($form, 'TitleColor')?>
            </div>
        </div>
    </div>
    <div class="control-group">
        <?=$activeForm->label($form, 'TextColor', ['class' => 'control-label'])?>
        <div class="controls">
            <div class="input-prepend">
                <span class="add-on">#</span>
                <?=$activeForm->textField($form, 'TextColor')?>
            </div>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success'])?>
        </div>
    </div>
    <?$this->endWidget()?>
</div>
