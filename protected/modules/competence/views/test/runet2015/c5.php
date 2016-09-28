<?php
/**
 * @var $form C5
 */

use competence\models\test\runet2015\C5;

$names = $form->getCompanyNames();
?>
<table class="form-inline table table-striped">
    <?foreach($names as $i => $name):?>
        <tr>
            <td style="vertical-align: middle;"><?=$name?></td>
            <td>
                <div class="input-append">
                    <?=CHtml::activeTextField($form, 'value[' . $i. ']', ['class' => 'span2'])?>
                    <span class="add-on">млн. рублей</span>
                </div>
            </td>
        </tr>
    <?endforeach?>
</table>