<?php
/**
 * @var $question \competence\models\tests\runet2013\D7
 */
?>
<h3>Ваши комментарии, замечания и предложения по анкете и исследованию в целом.</h3>
<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>
<?=\CHtml::activeTextArea($question, 'value', ['class' => 'input-block-level'])?>



