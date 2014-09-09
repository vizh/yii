<?php
/**
 * @var $form C8
 */

use competence\models\test\runet2014\C8;
?>

<table>
    <?foreach ($form->subMarkets as $key => $subMarket):?>
        <tr>
            <td><?=$subMarket;?></td>
            <td><?=CHtml::activeTextField($form, 'value', ['class' => 'input-block-level']);?></td>
        </tr>
    <?endforeach;?>
</table>