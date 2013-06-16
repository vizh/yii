<?php
/**
 * @var $question \competence\models\base\Single
 */
?>

<h3><?=$question->getQuestionTitle();?></h3>

<?php $this->widget('competence\components\ErrorsWidget', array('question' => $question));?>

<ul class="unstyled">
  <?foreach ($question->getValues() as $key => $value):?>
    <li>
      <label class="radio">
        <?=CHtml::activeRadioButton($question, 'value', array('value' => $key, 'uncheckValue' => null));?>
        <?=$value;?>
      </label>
    </li>
  <?endforeach;?>
</ul>