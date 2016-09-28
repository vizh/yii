<?php
/**
 * @var $question \competence\models\tests\mailru2013\E1_1
 */
?>

<h3>Какими из перечисленных источников информации Вы пользовались за последний месяц для <strong>получения информации об интернет-отрасли</strong>?<br><span>(Отметьте все подходящие)</span></h3>

<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>

<ul class="unstyled">
  <?foreach($question->getOptions() as $key => $value):?>
    <li>
      <label class="checkbox">
        <?=CHtml::activeCheckBox($question, 'value[]', array('value' => $key, 'uncheckValue' => null, 'checked' => in_array($key, $question->value), 'data-unchecker' => 1, 'data-unchecker-group' => 'group', 'data-unchecker-negative' => (int)($key==99), 'data-other' => $key==12 ? 'checkbox' : '', 'data-other-group' => 'group'))?>
        <?=$value?>
      </label>
      <?if($key == 12):?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=CHtml::activeTextField($question, 'other', array('class' => 'span4', 'data-other' => 'input', 'data-other-group' => 'group', 'disabled' => !in_array($key, $question->value)))?>
      <?endif?>
    </li>
  <?endforeach?>
</ul>
