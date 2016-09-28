<?php
/**
 * @var $form Single
 */
use competence\models\form\Single;
?>
<?=\CHtml::errorSummary($form, '<div class="alert alert-danger">', '</div>')?>
<div class="row">
    <div class="col-sm-8 col-sm-offset-4">
        <?foreach($form->Values as $value):?>
            <div class="radio">
                <label>
                    <?=CHtml::activeRadioButton($form, 'value', ['value' => $value->key, 'uncheckValue' => null])?>
                    <?=$value->title?>
                </label>
            </div>
        <?endforeach?>
    </div>
</div>
