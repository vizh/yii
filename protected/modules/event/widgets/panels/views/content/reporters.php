<?php
/**
 * @var Slider $this
 * @var \CActiveForm $activeForm
 * @var \event\models\forms\widgets\Base $form
 */

/** @var \CController $controller */
$controller = \Yii::app()->getController();
?>

<?$activeForm = $controller->beginWidget('CActiveForm', ['htmlOptions' => ['class' => 'form-horizontal']])?>
    <?foreach(array_keys($form->Attributes) as $attr):?>
        <div class="control-group">
            <?=$activeForm->label($form, $attr, ['class' => 'control-label'])?>
            <?if($attr == 'WidgetReportersOrder'):?>
                <div class="controls">
                    <?=$activeForm->dropDownList($form, 'Attributes[' . $attr . '][ru]', ['random()' => 'Случайная', '"t"."LastName"' => 'По фамилии'])?>
                </div>
            <?else:?>

            <?endif?>
        </div>
    <?endforeach?>
    <div class="control-group">
        <div class="controls">
            <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success'])?>
        </div>
    </div>
<?$controller->endWidget()?>
