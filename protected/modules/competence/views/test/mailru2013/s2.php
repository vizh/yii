<?php
/**
 * @var $question \competence\models\questions\s\S2
 */
?>


<h3>Как давно Вы работаете в этой сфере?<br><span>(Впишите, пожалуйста, полное количество лет)</span></h3>


<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>

<div class="form-inline">
  <label>Я работаю в этой сфере уже&nbsp;&nbsp;<?=CHtml::activeTextField($question, 'value', array('class' => 'span1'))?>&nbsp;&nbsp;лет.</label>
</div>