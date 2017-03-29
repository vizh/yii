<?php
/**
 * @var $form Q9
 */

use competence\models\test\iior17\Q9;

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
                    5 => 'Не пользовался',
                    1 => 'Результат положительный',
                    2 => 'Результат скорее положительный',
                    3 => 'Результат скорее отрицательный',
                    4 => 'Результат отрицательный'
                ], $attrs)?>
            </td>
        </tr>
    <?endforeach?>
</table>

