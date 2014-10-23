<?php
/**
 * @var $form Q6
 */
use competence\models\test\userexp14\Q6;
?>

<table class="form-inline table table-striped">
    <tr>
        <td style="vertical-align: middle;">Доклад 1</td>
        <td><?=CHtml::activeTextField($form, 'value[place1]', ['class' => 'input-block-level']);?></td>
    </tr>
    <tr>
        <td style="vertical-align: middle;">Доклад 2</td>
        <td><?=CHtml::activeTextField($form, 'value[place2]', ['class' => 'input-block-level']);?></td>
    </tr>
    <tr>
        <td style="vertical-align: middle;">Доклад 3</td>
        <td><?=CHtml::activeTextField($form, 'value[place3]', ['class' => 'input-block-level']);?></td>
    </tr>
</table>