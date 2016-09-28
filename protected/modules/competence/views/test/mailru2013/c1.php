<?php
/**
 * @var $question \competence\models\tests\mailru2013\C1
 */
?>
<p class="personal-info">В заключение несколько вопросов о Вас и о Вашей семье. Эта информация будет использоваться в обобщённом виде после статистической обработки.</p>


<h3>Впишите год вашего рождения</h3>


<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>

<div class="form-inline">
  <label>Я родился в &nbsp;&nbsp;<?=CHtml::activeTextField($question, 'value', array('class' => 'span1'))?>&nbsp;&nbsp;году.</label>
</div>