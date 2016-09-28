<?php
/**
 * @var $question \competence\models\tests\mailru2013\C3
 */
?>
<p class="personal-info">В заключение несколько вопросов о Вас и о Вашей семье. Эта информация будет использоваться в обобщённом виде после статистической обработки.</p>


<h3>В каком городе/регионе Вы живете постоянно?</h3>

<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>


<?=CHtml::activeDropDownList($question, 'value', $question->values, array('class' => 'span4'))?>
