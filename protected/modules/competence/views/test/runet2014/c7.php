<?php
/**
 * @var $form C7
 */

use competence\models\test\runet2014\C7;
?>

<table>
    <tr>
        <td>1.</td>
        <td><?=CHtml::activeTextField($form, 'value1', ['class' => 'input-block-level']);?></td>
    </tr>
    <tr>
        <td>2.</td>
        <td><?=CHtml::activeTextField($form, 'value2', ['class' => 'input-block-level']);?></td>
    </tr>
    <tr>
        <td>3.</td>
        <td><?=CHtml::activeTextField($form, 'value3', ['class' => 'input-block-level']);?></td>
    </tr>
</table>