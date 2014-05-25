<?php
/**
 * @var \competence\models\test\devcon14\Q2 $form
 */
?>


<ul class="unstyled">
    <?foreach ($form->getValues() as $value):?>
        <li>
            <label class="radio">
                <?=CHtml::activeRadioButton($form, 'value', ['value' => $value->key, 'uncheckValue' => null, 'data-group' => $form->getQuestion()->Code, 'data-target' => '#'.$form->getQuestion()->Code.'_'.$value->key]);?>
                <?=$value->title;?>
            </label>
            <?if ($value->isOther):?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=CHtml::activeTextField($form, 'other', ['class' => 'span4', 'data-group' => $form->getQuestion()->Code, 'id' => $form->getQuestion()->Code.'_'.$value->key]);?>
            <?endif;?>
        </li>
    <?endforeach;?>
</ul>

<div id="Q2_platforms" class="row" style="display: none;">
    <div class="span8 offset1">
        <ul class="unstyled">
            <?foreach ($form->getPlatforms() as $value):?>
                <li>
                    <label class="radio">
                        <?=CHtml::activeRadioButton($form, 'platform', ['value' => $value->key, 'uncheckValue' => null, 'data-group' => $form->getQuestion()->Code.'_pl', 'data-target' => '#'.$form->getQuestion()->Code.'_'.$value->key]);?>
                        <?=$value->title;?>
                    </label>
                    <?if ($value->isOther):?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=CHtml::activeTextField($form, 'other', ['class' => 'span4', 'data-group' => $form->getQuestion()->Code.'_pl', 'id' => $form->getQuestion()->Code.'_'.$value->key]);?>
                    <?endif;?>
                </li>
            <?endforeach;?>
        </ul>
    </div>
</div>


<div class="m-top_20">
    Ваш Microsoft Azure Subscription ID&nbsp;&nbsp;<?=CHtml::activeTextField($form, 'azure', ['class' => 'span4'])?> <span class="help-block">(вам помогут его найти или создать в гостевом доме Microsoft на стенде Azure)</span>
</div>

