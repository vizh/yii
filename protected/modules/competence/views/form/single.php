<?php
/**
 * @var $form Single
 */
use competence\models\form\attribute\RadioValue;
use competence\models\form\Single;

$left = [];
$right = [];
if (count($form->Values) > 6) {
    $half = count($form->Values) / 2;
    foreach ($form->Values as $value) {
        if (count($left) >= $half) {
            $right[] = $value;
        } else {
            $left[] = $value;
        }
    }
}

$printRadio = function(RadioValue $value, $wide = true) use ($form)
{
    ?>
    <li>
        <label class="radio">
            <?=CHtml::activeRadioButton($form, 'value', ['value' => $value->key, 'uncheckValue' => null, 'data-group' => $form->getQuestion()->Code, 'data-target' => '#'.$form->getQuestion()->Code.'_'.$value->key]);?>
            <?=$value->title;?>

            <?if (!empty($value->description)):?>
                <div class="value-description">
                    <?=$value->description;?>
                </div>
            <?endif;?>
        </label>
        <?if ($value->isOther):?>
            <?if (empty($value->suffix)):?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=CHtml::activeTextField($form, 'other', ['class' => $wide ? 'span4' : 'span3', 'data-group' => $form->getQuestion()->Code, 'id' => $form->getQuestion()->Code.'_'.$value->key]);?>
            <?else:?>
                <div style="margin-left: 18px;" class="input-append">
                    <?=CHtml::activeTextField($form, 'other', ['class' => $wide ? 'span4' : 'span3', 'data-group' => $form->getQuestion()->Code, 'id' => $form->getQuestion()->Code.'_'.$value->key]);?>
                    <span class="add-on"><?=$value->suffix;?></span>
                </div>
            <?endif;?>
        <?endif;?>
    </li>
<?
};
?>

<?if (empty($left)):?>
    <ul class="unstyled">
        <?php foreach ($form->Values as $value) {
            $printRadio($value);
        } ?>
    </ul>
<?else:?>
    <div class="row">
        <div class="span4">
            <ul class="unstyled">
                <?php foreach ($left as $value) {
                    $printRadio($value, false);
                } ?>
            </ul>
        </div>
        <div class="span4 offset1">
            <ul class="unstyled">
                <?php foreach ($right as $value) {
                    $printRadio($value, false);
                } ?>
            </ul>
        </div>
    </div>
<?endif;?>
