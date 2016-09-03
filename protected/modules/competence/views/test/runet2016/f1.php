<?php
/**
 * @var $form F1
 */

use competence\models\test\runet2016\F1;

$attrs = [
    'class' => 'input-block-level'
];
?>

<table class="form-inline table table-striped">
    <tr>
        <th class="span2">RUNET-ID<br><small class="muted">(если есть)</small></th>
        <th class="span6">ФИО</th>
        <th class="span4">Email</th>
    </tr>
    <?for ($i=0;$i<5;$i++):?>
        <tr>
            <td><?=CHtml::activeTextField($form, 'value[' . $i . '][runet_id]', ['class' => 'input-block-level']);?></td>
            <td><?=CHtml::activeTextField($form, 'value[' . $i . '][fio]', ['class' => 'input-block-level']);?></td>
            <td><?=CHtml::activeTextField($form, 'value[' . $i . '][email]', ['class' => 'input-block-level']);?></td>
        </tr>
    <?endfor;?>
</table>