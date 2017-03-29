<?php
/**
 * @var $form Q18
 */

use competence\models\test\iior17\Q18;

$attrs = [
    'class' => 'input-block-level'
];
?>

<table class="form-inline table table-striped">
    <?foreach($form->subMarkets as $key => $subMarket):?>
        <tr>
            <td style="vertical-align: middle;"><?=$subMarket?></td>
            <td>
                <?=CHtml::activeDropDownList($form, 'value[' . $key . '][type]', [
                    0 => '- Не пользовался -',
                    'smm' => 'Через социальные сети',
                    'web' => 'Через сайты органов государственной власти',
                    'mail' => 'Адресно по электронной почте'
                ], $attrs)?>
            </td>
            <td>
                <?=CHtml::activeDropDownList($form, 'value[' . $key . '][result]', [
                    0 => '- Оцените -',
                    1 => 'Результат положительный',
                    2 => 'Результат скорее положительный',
                    3 => 'Результат скорее отрицательный',
                    4 => 'Результат отрицательный'
                ], $attrs)?>
            </td>
        </tr>
    <?endforeach?>
</table>

