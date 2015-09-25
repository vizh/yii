<?
/**
 * @var \event\components\Widget $this
 * @var \event\models\forms\widgets\header\Header $form
 * @var \application\widgets\ActiveForm $activeForm
 */
?>
<?php $activeForm = $this->beginWidget('\application\widgets\ActiveForm', ['htmlOptions' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data']]);?>
    <div class="control-group">
        <?=$activeForm->label($form, 'WidgetHeaderStyles', ['class' => 'control-label']);?>
        <div class="controls">
            <?=$activeForm->textArea($form, 'WidgetHeaderStyles', ['class' => 'input-block-level']);?>
        </div>
    </div>
    <div class="control-group">
        <?=$activeForm->label($form, 'WidgetHeaderBackgroundImage', ['class' => 'control-label']);?>
        <div class="controls">
            <?=$activeForm->fileField($form, 'WidgetHeaderBackgroundImage');?>
            <?php if ($form->getActiveRecord()->getHeaderBackgroundImage()->exists()):?>
                <div>
                    <?=\CHtml::image($form->getActiveRecord()->getHeaderBackgroundImage()->get200px(), '', ['class' => 'm-top_10']);?>
                </div>
            <?php endif;?>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']); ?>
        </div>
    </div>
<?php $this->endWidget();?>