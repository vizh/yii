<?php
/**
 * @var $form C5
 */

use competence\models\test\runet2015\C5;

$names = $form->getCompanyNames();
?>
<table class="form-inline table table-striped">
    <?php foreach ($names as $i => $name):?>
        <tr>
            <td style="vertical-align: middle;"><?=$name;?></td>
            <td><?=CHtml::activeTextField($form, 'value[' . $i. ']', ['class' => 'input-block-level']);?></td>
            <td style="white-space: nowrap;">млн. рублей</td>
        </tr>
    <?php endforeach;?>
</table>