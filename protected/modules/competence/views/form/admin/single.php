<?php
/**
 * @var \competence\models\Question $question
 */

/** @var \competence\models\form\Single $form */
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
  </tr>
  </thead>
  <tbody>
  <?for ($i=0; $i<$rows;$i++):?>
    <?$value = isset($values[$i]) ? $values[$i] : new \competence\models\form\attribute\RadioValue();?>
    <tr>
      <td>
        <input class="span1" type="text" name="Single[<?=$i?>][key]" value="<?=$value->key;?>" autocomplete="off"/>
      </td>
      <td>
        <input class="span5" type="text" name="Single[<?=$i?>][title]" value="<?=$value->title;?>"/>
      </td>

            <td>
                <textarea class="span5" name="Single[<?=$i?>][description]"  rows="3"><?=$value->description;?></textarea>
            </td>

      <td>
        <label class="checkbox">
          <input type="checkbox" name="Single[<?=$i?>][isOther]" <?=$value->isOther ? 'checked' : '';?>  value="1"/>
          да
        </label>
      </td>
      <td>
        <input class="span1" type="text" name="Single[<?=$i?>][sort]" value="<?=$value->sort;?>"/>
      </td>
    </tr>
  <?endfor;?>
  </tbody>
</table>