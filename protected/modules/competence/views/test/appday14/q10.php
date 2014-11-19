<?php
/**
 * @var \competence\models\test\devcon14\Q9 $form
 */
?>

<div class="row q9_head">
    <div class="span2 offset5 text-center"><?=$form->getValues()['yes'];?></div>
    <div class="span2 text-center"><?=$form->getValues()['want'];?></div>
</div>

<?foreach ($form->getQuestions() as $qKey => $question):?>

    <div class="row m-top_10">
        <div class="span5"><?=$question;?></div>
        <?foreach ($form->getValues() as $key => $value):?>
            <?
            $attrs = [
                'value' => $key,
                'uncheckValue' => null,
                'data-group' => $form->getQuestion()->Code.'_'.$qKey,
                'data-unchecker' => (int)($key == 'want'),
                'checked' => isset($form->value[$qKey]) && $form->value[$qKey] == $key
            ];
            ?>
            <div class="span2 text-center">
                <?=CHtml::activeCheckBox($form, 'value['.$qKey.']', $attrs);?>
            </div>
        <?endforeach;?>
    </div>
<?endforeach;?>