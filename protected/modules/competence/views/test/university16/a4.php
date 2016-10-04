<?php
/**
 * @var $form \competence\models\form\Multiple
 */

if (!function_exists('printCheckBox')) {
    function printCheckBox(\competence\models\form\Multiple $form, \competence\models\form\attribute\CheckboxValue $value, $wide = true)
    {
        $attrs = [
            'value' => $value->key,
            'uncheckValue' => null,
            'data-group' => $form->getQuestion()->Code,
            'data-unchecker' => (int)$value->isUnchecker,
            'checked' => in_array($value->key, $form->value)
        ];
        if ($value->isOther) {
            $attrs['data-target'] = '#' . $form->getQuestion()->Code . '_' . $value->key;
        }
        ?>
        <li>
            <label class="checkbox">
                <?=CHtml::activeCheckBox($form, 'value[]', $attrs)?>
                <?=$value->title?>

                <?if (!empty($value->description)):?>
                    <div class="value-description">
                        <?=$value->description?>
                    </div>
                <?endif?>
            </label>
            <?if ($value->isOther):?>
                <?if (empty($value->suffix)):?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=CHtml::activeTextField($form, 'other', ['class' => $wide ? 'span4' : 'span3', 'data-group' => $form->getQuestion()->Code, 'id' => $form->getQuestion()->Code . '_' . $value->key])?>
                    <?
                else:?>
                    <div style="margin-left: 18px;" class="input-append">
                        <?=CHtml::activeTextField($form, 'other', ['class' => $wide ? 'span4' : 'span3', 'data-group' => $form->getQuestion()->Code, 'id' => $form->getQuestion()->Code . '_' . $value->key])?>
                        <span class="add-on"><?=$value->suffix?></span>
                    </div>
                <?endif?>
            <?endif?>
        </li>
        <?
    }
}
?>

<ul class="unstyled">
    <?
    foreach ($form->Values as $value) {
        printCheckBox($form, $value);
    }
    ?>
</ul>
