<?php
/**
 * @var $question \competence\models\tests\mailru2013\A9
 */

$options = (new \competence\models\tests\mailru2013\A6($question->getTest()))->getOptions();
$options[98] = 'Другое (укажите, какая именно)';
$options[99] = 'Никто из перечисленных';
$part1 = $part2 = array();
$i = 0;
foreach ($options as $key => $value)
{
  $i++;
  if ($i % 2 == 1)
  {
    $part1[$key] = $value;
  }
  else
  {
    $part2[$key] = $value;
  }
}
?>

<h3><strong>Сотрудники</strong> каких компаний, по Вашему мнению, наиболее заметны на специализированных выставках/мероприятиях?</h3>

<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>

<div class="row">
  <div class="span4">
    <ul class="unstyled">
      <?foreach($part1 as $key => $value):?>
      <li>
        <label class="checkbox">
          <?=CHtml::activeCheckBox($question, 'value[]', array('value' => $key, 'uncheckValue' => null, 'checked' => in_array($key, $question->value), 'data-unchecker' => 1, 'data-unchecker-group' => 'group', 'data-unchecker-negative' => (int)($key==99), 'data-other' => $key==98 ? 'checkbox' : '', 'data-other-group' => 'group'))?>
          <?=$value?>
        </label>
        <?if($key == 98):?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=CHtml::activeTextField($question, 'other', array('class' => 'span4', 'data-other' => 'input', 'data-other-group' => 'group', 'disabled' => !in_array($key, $question->value)))?>
        <?endif?>
      </li>
      <?endforeach?>
    </ul>
  </div>
  <div class="span5">
    <ul class="unstyled">
      <?foreach($part2 as $key => $value):?>
      <li>
        <label class="checkbox">
          <?=CHtml::activeCheckBox($question, 'value[]', array('value' => $key, 'uncheckValue' => null, 'checked' => in_array($key, $question->value), 'data-unchecker' => 1, 'data-unchecker-group' => 'group', 'data-unchecker-negative' => (int)($key==99), 'data-other' => $key==98 ? 'checkbox' : '', 'data-other-group' => 'group'))?>
          <?=$value?>
        </label>
        <?if($key == 98):?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=CHtml::activeTextField($question, 'other', array('class' => 'span4', 'data-other' => 'input', 'data-other-group' => 'group', 'disabled' => !in_array($key, $question->value)))?>
        <?endif?>
      </li>
      <?endforeach?>
    </ul>
  </div>
</div>