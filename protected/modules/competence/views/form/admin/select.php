<?php
/**
 * @var competence\models\Question $question
 */

use competence\models\form\Single;
use competence\models\form\attribute\CheckboxValue;

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
        <th>Сортировка</th>
    </tr>
    </thead>
    <tbody>
    <?php for ($i = 0; $i < $rows; $i++):?>
        <?$value = isset($values[$i]) ? $values[$i] : new CheckboxValue()?>
        <tr>
            <td>
                <input class="span1" type="text" name="Multiple[<?=$i?>][key]" value="<?=$value->key?>"
                       autocomplete="off"/>
            </td>
            <td>
                <input class="span5" type="text" name="Multiple[<?=$i?>][title]" value="<?=$value->title?>"/>
            </td>
            <td>
                <textarea class="span5" name="Multiple[<?=$i?>][description]"
                          rows="3"><?=$value->description?></textarea>
            </td>
            <td>
                <input class="span1" type="text" name="Multiple[<?=$i?>][sort]" value="<?=$value->sort?>"/>
            </td>
        </tr>
    <?php endfor?>
    </tbody>
</table>
