<?php
/**
 * @var competence\models\Question $question
 */

use competence\models\form\attribute\CheckboxValue;
use competence\models\form\Single;

/** @var Single $form */
$form = $question->getForm();

$values = !empty($form->Values) ? $form->Values : [];
$rows = count($values) + 10;
?>

<h5>Варианты ответов</h5>

<table class="table">
    <thead>
    <tr>
        <th>Ключ</th>
        <th>Значение</th>
        <th>Описание</th>
        <th>Ввод своего значения</th>
        <th>Сортировка</th>
        <th>Исключающее значение</th>
    </tr>
    </thead>
    <tbody>
    <?php for ($i = 0; $i < $rows; $i++):?>
        <?$value = isset($values[$i]) ? $values[$i] : new CheckboxValue()?>
        <tr>
            <td>
                <input class="span1" type="text" name="Multiple[<?=$i?>][key]"
                       value="<?=CHtml::encode($value->key)?>"
                       autocomplete="off">
            </td>
            <td>
                <input class="span5" type="text" name="Multiple[<?=$i?>][title]"
                       value="<?=CHtml::encode($value->title)?>">
            </td>
            <td>
                <textarea class="span5" name="Multiple[<?=$i?>][description]"
                          rows="3"><?=$value->description?></textarea>
            </td>
            <td>
                <label class="checkbox">
                    <input type="checkbox" name="Multiple[<?=$i?>][isOther]" <?=$value->isOther ? 'checked' : ''?>
                           value="1">
                    да
                </label>
                <input type="text" name="Multiple[<?=$i?>][suffix]" value="<?=$value->suffix?>"
                       placeholder="Суффикс">
            </td>
            <td>
                <input class="span1" type="text" name="Multiple[<?=$i?>][sort]" value="<?=$value->sort?>">
            </td>
            <td>
                <label class="checkbox">
                    <input type="checkbox"
                           name="Multiple[<?=$i?>][isUnchecker]" <?=$value->isUnchecker ? 'checked' : ''?>
                           value="1">
                    да
                </label>
            </td>
        </tr>
    <?php endfor?>
    </tbody>
</table>