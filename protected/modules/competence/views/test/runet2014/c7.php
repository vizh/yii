<?php
/**
 * @var $form C7
 */

use competence\models\test\runet2014\C7;
?>

<table class="form-inline table table-striped">
    <tr>
        <td style="vertical-align: middle;">Компания 1</td>
        <td><?=CHtml::activeTextField($form, 'value[place1]', ['class' => 'input-block-level']);?></td>
    </tr>
    <tr>
        <td style="vertical-align: middle;">Компания 2</td>
        <td><?=CHtml::activeTextField($form, 'value[place2]', ['class' => 'input-block-level']);?></td>
    </tr>
    <tr>
        <td style="vertical-align: middle;">Компания 3</td>
        <td><?=CHtml::activeTextField($form, 'value[place3]', ['class' => 'input-block-level']);?></td>
    </tr>
</table>