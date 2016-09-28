<?php
/**
 * @var \competence\models\test\runet2015\D1 $form
 */
?>
<table class="table table-striped">
    <?foreach($form->getQuestions() as $key => $question):?>
        <tr>
            <td><strong><?=$question?></strong></td>
            <td style="width: 70px; text-align: right;">
                <?
                $attrs = [
                    'class' => 'input-block-level'
                ];
               ?>
                <?=\CHtml::activeDropDownList($form, 'value['.$key.']', ['' => '', 0=> 0, 1 => 1,2 => 2, 3=> 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10], $attrs)?>
            </td>
        </tr>
    <?endforeach?>
</table>