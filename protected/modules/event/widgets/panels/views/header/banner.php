<?
/**
 * @var \event\widgets\panels\header\Banner $this
 * @var \event\models\forms\widgets\header\Banner $form
 * @var \application\widgets\ActiveForm $activeForm
 */

$event = $form->getActiveRecord();
?>
<?$activeForm = $this->beginWidget('\application\widgets\ActiveForm', ['htmlOptions' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data']])?>
    <div class="control-group">
        <?=$activeForm->label($form, 'WidgetHeaderStyles', ['class' => 'control-label'])?>
        <div class="controls">
            <?=$activeForm->textArea($form, 'WidgetHeaderStyles', ['class' => 'input-block-level'])?>
        </div>
    </div>
    <div class="control-group">
        <?=$activeForm->label($form, 'WidgetHeaderBackgroundImage', ['class' => 'control-label'])?>
        <div class="controls">
            <?=$activeForm->fileField($form, 'WidgetHeaderBackgroundImage')?>
            <?if($event->getHeaderBackgroundImage()->exists()):?>
                <div>
                    <?=\CHtml::image($event->getHeaderBackgroundImage()->get200px(), '', ['class' => 'm-top_10'])?>
                </div>
            <?endif?>
        </div>
    </div>
    <div class="control-group">
        <?=$activeForm->label($form, 'WidgetHeaderBannerBackgroundColor', ['class' => 'control-label'])?>
        <div class="controls">
            <div class="input-append">
                <span class="add-on">#</span>
                <?=$activeForm->textField($form, 'WidgetHeaderBannerBackgroundColor')?>
            </div>
        </div>
    </div>
    <div class="control-group">
        <?=$activeForm->label($form, 'WidgetHeaderBannerImage', ['class' => 'control-label'])?>
        <div class="controls">
            <?=$activeForm->fileField($form, 'WidgetHeaderBannerImage')?>
            <?if($event->getHeaderBannerImage()->exists()):?>
                <div>
                    <?=\CHtml::image($event->getHeaderBannerImage()->get200px(), '', ['class' => 'm-top_10'])?>
                </div>
            <?endif?>
        </div>
    </div>
    <div class="control-group">
        <?=$activeForm->label($form, 'WidgetHeaderBannerImage_en', ['class' => 'control-label'])?>
        <div class="controls">
            <?=$activeForm->fileField($form, 'WidgetHeaderBannerImage_en')?>
            <?php
            $event->setLocale('en');
            if ($event->getHeaderBannerImage()->exists()):?>
                <div><?=\CHtml::image($event->getHeaderBannerImage()->get200px(), '', ['class' => 'm-top_10'])?></div>
            <?php endif;
            $event->resetLocale();
           ?>
        </div>
    </div>
    <div class="control-group">
        <?=$activeForm->label($form, 'WidgetHeaderBannerHeight', ['class' => 'control-label'])?>
        <div class="controls">
            <?=$activeForm->textField($form, 'WidgetHeaderBannerHeight')?>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success'])?>
        </div>
    </div>
<?$this->endWidget()?>