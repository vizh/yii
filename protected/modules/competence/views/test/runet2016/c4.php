<?php
/**
 * @var $form C8
 */

use competence\models\test\runet2015\C8;
?>

<table class="form-inline table table-striped">
    <?for ($i=0;$i<5;$i++):?>
        <tr>
            <td><?=CHtml::activeTextField($form, 'value[' . $i . '][factor]', ['class' => 'input-block-level']);?></td>
            <td><?=CHtml::activeTextField($form, 'value[' . $i . '][estimation]', ['class' => 'input-block-level']);?></td>
            <td><?=CHtml::activeTextField($form, 'value[' . $i . '][rate]', ['class' => 'input-block-level']);?></td>
        </tr>
    <?endfor;?>
</table>