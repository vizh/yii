<?php
/**
 * @var $form C3A|QuestionsByCode
 */

use competence\models\test\runet2014\C3A;
use competence\models\test\runet2014\QuestionsByCode;

$questions = $form->getQuestions($form->getQuestion()->TestId, $form->getCodes())
?>

<ol class="muted m-bottom_30" style="margin-top: -20px;">
<?foreach ($questions as $question):?>
    <li><?=$question->Title;?></li>
<?endforeach;?>
</ol>

<ul class="unstyled">
    <li>
        <?=CHtml::activeTextArea($form, 'value', ['class' => 'input-block-level']);?>
    </li>
</ul>