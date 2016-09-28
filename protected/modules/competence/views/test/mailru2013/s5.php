<?php
/**
 * @var $question \competence\models\tests\mailru2013\S5
 */
?>
<p class="personal-info">В заключение несколько вопросов о Вас и о Вашей семье. Эта информация будет использоваться в обобщённом виде после статистической обработки.</p>


<h3>Укажите, пожалуйста, какую позицию Вы занимаете в компании?</h3>

<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>

<ul class="unstyled">
  <?foreach($question->values as $key => $value):?>
  <li>
    <label class="radio">
      <?=CHtml::activeRadioButton($question, 'value', ['value' => $key, 'uncheckValue' => null, 'data-group' => 's5', 'data-target' => $key == 98 ? '[name*="other"]' : null])?>
      <?=$value?>
    </label>
    <?if($key == 98):?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=CHtml::activeTextField($question, 'other', ['class' => 'span4', 'data-other' => 'input', 'data-group' => 's5'])?>
    <?endif?>
  </li>
  <?endforeach?>
</ul>
