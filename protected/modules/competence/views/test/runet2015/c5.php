<?php
/**
 * @var $form C5
 */

use competence\models\test\runet2015\C5;
?>
<table class="form-inline table table-striped">
    <tr>
        <td style="vertical-align: middle;"><?=$form->getCompanyNames()[1];?></td>
        <td><?=CHtml::activeTextField($form, 'value[1]', ['class' => 'input-block-level']);?></td>
        <td style="white-space: nowrap;">млн. рублей</td>
    </tr>
    <tr>
        <td style="vertical-align: middle;"><?=$form->getCompanyNames()[2];?></td>
        <td><?=CHtml::activeTextField($form, 'value[2]', ['class' => 'input-block-level']);?></td>
        <td style="white-space: nowrap;">млн. рублей</td>
    </tr>
    <tr>
        <td style="vertical-align: middle;"><?=$form->getCompanyNames()[3];?></td>
        <td><?=CHtml::activeTextField($form, 'value[3]', ['class' => 'input-block-level']);?></td>
        <td style="white-space: nowrap;">млн. рублей</td>
    </tr>
    <tr>
        <td style="vertical-align: middle;"><?=$form->getCompanyNames()[4];?></td>
        <td><?=CHtml::activeTextField($form, 'value[4]', ['class' => 'input-block-level']);?></td>
        <td style="white-space: nowrap;">млн. рублей</td>
    </tr>
</table>