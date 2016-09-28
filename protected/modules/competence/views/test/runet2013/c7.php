<?php
/**
 * @var $question \competence\models\tests\runet2013\B6_base
 */
?>
<h3>Вопрос C7 по рынку <strong><?=$question->getMarketTitle()?></strong></h3>
<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>
Текст вопроса