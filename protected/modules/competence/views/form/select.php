<?php
/**
 * @var competence\models\form\Select $form
 */

$values = [];
if (!empty($form->Values)) {
    $values = CHtml::listData($form->Values, 'key', 'title');
}
?>

<div>
    <?=CHtml::activeDropDownList($form, 'value', $values, [
        'class' => 'input-block-level',
        'prompt' => 'Выберите значение из списка ...'
    ])?>
</div>


