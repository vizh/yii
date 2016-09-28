<?php
/**
 * @var $form C4
 */

use competence\models\test\runet2016\C4;

$attrs = [
    'class' => 'input-block-level'
];
?>

<table class="form-inline table table-striped">
    <tr>
        <th class="span8">Фактор влияния</th>
        <th class="span4">Оценка влияния</th>
        <th class="span4">Степень влияния</th>
    </tr>
    <?for ($i=0;$i<5;$i++):?>
        <tr>
            <td><?=CHtml::activeTextField($form, 'value[' . $i . '][factor]', ['class' => 'input-block-level'])?></td>
            <td><?=CHtml::activeDropDownList($form, 'value[' . $i . '][estimation]', [
                    '' => '', 'pos' => 'Положительная', 'neg' => 'Отрицательная'
                ], $attrs)?></td>
            <td><?=CHtml::activeDropDownList($form, 'value[' . $i . '][rate]', [
                    '' => '', 'weak' => 'Слабое', 'med' => 'Среднее', 'strong' => 'Сильное', 'v_strong' => 'Очень сильное',
                ], $attrs)?></td>
        </tr>
    <?endfor?>
</table>