<?php
/**
 * @var $form C8
 */

use competence\models\test\runet2014\C8;
?>

<table class="form-inline table table-striped">
    <?foreach ($form->subMarkets as $key => $subMarket):?>
        <tr>
            <td style="vertical-align: middle;"><?=$subMarket;?></td>
            <td><?=CHtml::activeTextField($form, 'value[' . $key . ']', ['class' => 'input-block-level']);?></td>
        </tr>
    <?endforeach;?>
</table>