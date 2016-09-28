<?php
/**
 * @var \event\widgets\panels\content\Html $this
 * @var \event\widgets\content\Html $widget
 * @var \event\models\forms\widgets\Base $form
 * @var CActiveForm $activeForm
 */

/** @var \CController $controller */
$controller = \Yii::app()->getController();

\Yii::app()->getClientScript()->registerPackage('runetid.ckeditor');
?>
<script type="text/javascript">
    $(function () {
        var $textarea = $('textarea[id*="Base_Attributes_HtmlContentContent"]');
        $textarea.each(function () {
            CKEDITOR.replace($(this).attr('id'), {
                customConfig : 'config_admin.js'
            });
        });
    });
</script>

<?$activeForm = $controller->beginWidget('CActiveForm')?>
    <?foreach($widget->getAttributeNames() as $name):?>
        <div class="control-group">
            <?foreach($form->getLocaleList() as $locale):?>
                <label class="control-label" style="text-transform: uppercase; margin-top: 20px; font-weight: bold;"><?=$locale?></label>
                <div class="controls">
                    <?=$activeForm->textArea($form, 'Attributes[' . $name . '][' . $locale . ']')?>
                </div>
            <?endforeach?>
        </div>
    <?endforeach?>
    <div class="control-group">
        <div class="controls">
            <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success'])?>
        </div>
    </div>
<?$controller->endWidget()?>