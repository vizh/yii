<?php
/**
 * @var Q1_3 $form
 */

use competence\models\test\govsiterating15\Q1_3;
?>
<?php foreach ($form->getPairValues() as $key => $pair):?>
    <div class="row m-top_10">
        <div class="span1"></div>
        <?php foreach ($pair as $value => $label):?>
            <div class="span3 text-center">
                <?=$label;?>
                <?php
                $attr = [
                    'value' => $value,
                    'uncheckValue' => null,
                    'data-group' => $form->getQuestion()->Code.'_'.$key
                ];
                ?>
                <p><?=\CHtml::activeRadioButton($form, 'value['. $key .']', $attr);?></p>
            </div>
        <?php endforeach;?>
    </div>
    <div class="row">
        <div class="span6 offset1"><hr/></div>
    </div>
<?php endforeach;?>