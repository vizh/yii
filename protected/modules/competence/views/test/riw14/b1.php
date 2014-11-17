<?
/**
 * @var \competence\models\test\riw14\B1 $form
 */
?>
<?foreach ($form->getQuestions() as $key => $question):?>
    <div class="control-group">
        <label class="control-label"><?=$question;?></label>
        <div class="controls">
            <?=CHtml::activeDropDownList($form, 'value['.$key.']', ['' => 'Выбрать ответ', 5=>5,4=>4,3=>3,2=>2,1=>1]);?>
        </div>
    </div>
<?endforeach;?>