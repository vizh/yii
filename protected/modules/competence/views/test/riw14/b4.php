<?
/**
 * @var \competence\models\test\riw14\B4 $form
 */
?>
<?foreach ($form->getQuestions() as $key => $question):?>
    <div class="control-group">
        <label class="control-label"><?=$question;?></label>
        <div class="controls">
            <?
            if ($key == 5) {
                $values = ['' => 'Выбрать ответ', 1 => 'В самый раз', 2 => 'Часто', 3 => 'Очень часто'];
            } else {
                $values = ['' => 'Выбрать ответ', 5 => 5, 4 => 4, 3 => 3, 2 => 2, 1 => 1];
            }
            ?>
            <?=CHtml::activeDropDownList($form, 'value['.$key.']', $values);?>
        </div>
    </div>
<?endforeach;?>