<?php
/**
 * @var \competence\models\test\msdtnovosib15\Q7 $form
 */
?>

<table class="table table-striped">
    <tbody>
    <?foreach($form->getQuestions() as $key => $question):?>

        <tr>
            <td class="span8"><?=$question?></td>
            <td>
                <?=CHtml::activeDropDownList($form, 'value['.$key.']', $form->getValues(), ['class' => 'span1'])?>
            </td>
        </tr>

    <?endforeach?>
    </tbody>
</table>

<p>Ваши комментарии и пожелания по организационным вопросам конференции:</p>
<?=CHtml::activeTextArea($form, 'other', ['class' => 'span9', 'rows' => 4])?>