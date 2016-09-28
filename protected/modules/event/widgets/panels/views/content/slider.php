<?php
/**
 * @var Slider $this
 * @var \CActiveForm $activeForm
 * @var \event\models\forms\widgets\Base $form
 */

use \event\widgets\panels\content\Slider;

/** @var \CController $controller */
$controller = \Yii::app()->getController();
?>

<?$activeForm = $controller->beginWidget('CActiveForm', ['htmlOptions' => ['class' => 'form-horizontal']])?>
    <?foreach(array_keys($form->Attributes) as $attr):?>
        <?if($attr == Slider::CONTENT_ATTRIBUTE_NAME) continue?>
        <div class="control-group">
            <?=$activeForm->label($form, $attr, ['class' => 'control-label'])?>
            <div class="controls">
                <?foreach($form->getLocaleList() as $locale):?>
                    <div class="m-bottom_5">
                        <div class="input-append">
                            <?=$activeForm->textField($form, 'Attributes['.$attr.']['.$locale.']', ['class' => 'input-xxlarge'])?>
                            <span class="add-on"><?=$locale?></span>
                        </div>
                    </div>
                <?endforeach?>
            </div>
        </div>
    <?endforeach?>
    <hr/>

    <?php for($i = 0; $i < 15; $i++):?>
        <div class="control-group">
            <?foreach($form->getLocaleList() as $locale):?>
                <label class="control-label">Слайд <?=$i+1?> <span class="label"><?=$locale?></span></label>
                <div class="controls">
                    <?=$activeForm->textArea($form, 'Attributes[' . Slider::CONTENT_ATTRIBUTE_NAME . '][' . $locale . '][' . $i . ']', ['class' => 'input-block-level m-bottom_5'])?>
                </div>
            <?endforeach?>
        </div>
        <hr/>
    <?php endfor?>
    <div class="control-group">
        <div class="controls">
            <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success'])?>
        </div>
    </div>
<?$controller->endWidget()?>
