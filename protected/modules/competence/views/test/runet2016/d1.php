<?php
/**
 * @var $form D1
 */

use competence\models\test\runet2016\D1;
?>

<table class="form-inline table table-striped">
    <?foreach ($form->subMarkets as $key => $subMarket):?>
        <tr>
            <td style="vertical-align: middle;"><?=$subMarket;?></td>
            <td>
                <div class="input-append">
                    <?=CHtml::activeTextField($form, 'value[' . $key . ']', ['class' => 'input-block-level']);?>
                    <span class="add-on">%</span>
                </div>
            </td>
        </tr>
    <?endforeach;?>
</table>

