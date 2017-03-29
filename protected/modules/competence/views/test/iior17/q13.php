<?php
/**
 * @var $form Q13
 */

use competence\models\test\iior17\Q13;

$attrs = [
    'class' => 'input-block-level'
];
?>

<table class="form-inline table table-striped">
    <?foreach($form->subMarkets as $key => $subMarket):?>
        <tr>
            <td style="vertical-align: middle;"><?=$subMarket?></td>
            <td>
                <?=CHtml::activeDropDownList($form, 'value[' . $key . ']', [
                    0 => 'Не пользовался',
                    10 => '10 баллов',
                    9 => '9 баллов',
                    8 => '8 баллов',
                    7 => '7 баллов',
                    6 => '6 баллов',
                    5 => '5 баллов',
                    4 => '4 балла',
                    3 => '3 балла',
                    2 => '2 балла',
                    1 => '1 балл',
                ], $attrs)?>
            </td>
        </tr>
    <?endforeach?>
</table>

