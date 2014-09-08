<?php
/**
 * @var \competence\models\test\runet2014\D2 $form
 */
?>
<table class="table table-striped">
    <?foreach ($form->getQuestions() as $qKey => $question):?>
        <tr>
            <td><strong><?=$question[0];?></strong></td>
            <td><?=$question[1];?></td>
            <td>
                <?
                $attrs = [
                    'class' => 'input-block-level'
                ];
                ?>
                <?=\CHtml::activeDropDownList($form, 'value['.$qKey.']', $form->getValues(), $attrs);?>
            </td>
        </tr>
    <?endforeach;?>
</table>