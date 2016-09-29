<?php
/**
 * @var $form С4
 */

use competence\models\test\runet2015\С4;
?>

<table class="form-inline table table-striped">
    <tr>
        <td style="vertical-align: middle;">Компания 1</td>
        <td><?=CHtml::activeTextField($form, 'value[1]', ['class' => 'input-block-level'])?></td>
    </tr>
    <tr>
        <td style="vertical-align: middle;">Компания 2</td>
        <td><?=CHtml::activeTextField($form, 'value[2]', ['class' => 'input-block-level'])?></td>
    </tr>
    <tr>
        <td style="vertical-align: middle;">Компания 3</td>
        <td><?=CHtml::activeTextField($form, 'value[3]', ['class' => 'input-block-level'])?></td>
    </tr>
    <tr>
        <td style="vertical-align: middle;">Компания 4</td>
        <td><?=CHtml::activeTextField($form, 'value[4]', ['class' => 'input-block-level'])?></td>
    </tr>
</table>