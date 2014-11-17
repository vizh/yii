<?
/**
 * @var \competence\models\test\riw14\B2 $form
 */
?>
<?foreach ($form->getQuestions() as $key => $question):?>
    <div class="control-group">
        <label class="control-label"><?=$question;?></label>
        <div class="controls">
            <?
            if ($key == 2) {
                $values = ['' => 'Выбрать ответ', 1=>'Лушче',2 => 'Разница не заметна', 3 => 'Хуже'];
            } else {
                $values = ['' => 'Выбрать ответ', 5 => 5, 4 => 4, 3 => 3, 2 => 2, 1 => 1];
            }
            ?>
            <?=CHtml::activeDropDownList($form, 'value['.$key.']', $values);?>
        </div>
    </div>
<?endforeach;?>