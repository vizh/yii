<?php
/**
 * @var $question \competence\models\tests\mailru2013\E5
 */
$fullData = $question->getFullData();
?>

<h3>Отметьте, пожалуйста, насколько Вы доверяете<br>или не доверяете информации, полученной<br>от представленных лиц?</h3>

<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>

<ul class="unstyled">
  <?foreach($question->options as $key => $value):?>
  <li>
    <h4><?=$value?></h4>
    <?=CHtml::activeDropDownList($question, 'value['.$key.']', $question->values, ['class' => 'span4'])?>
  </li>
  <?endforeach?>
</ul>
