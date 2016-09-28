<?php
/**
 * @var $question \competence\models\tests\mailru2013\C6
 */
$part1 = $part2 = array();
$i = 0;
foreach ($question->values as $key => $value)
{
  $i++;
  if ($i < sizeof($question->values) / 2 + 1)
  {
    $part1[$key] = $value;
  }
  else
  {
    $part2[$key] = $value;
  }
}

?>

<h3>Укажите сферы вашей профессиональной деятельности и интересов (не более 3)</h3>

<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>

<div class="row">
  <div class="span4">
    <ul class="unstyled">
      <?foreach($part1 as $key => $value):?>
      <li>
        <label class="checkbox">
          <?=CHtml::activeCheckBox($question, 'value[]', array('value' => $key, 'uncheckValue' => null, 'checked' => in_array($key, $question->value)))?>
          <?=$value?>
        </label>
      </li>
      <?endforeach?>
    </ul>
  </div>
  <div class="span5">
    <ul class="unstyled">
      <?foreach($part2 as $key => $value):?>
      <li>
        <label class="checkbox">
          <?=CHtml::activeCheckBox($question, 'value[]', array('value' => $key, 'uncheckValue' => null, 'checked' => in_array($key, $question->value)))?>
          <?=$value?>
        </label>
      </li>
      <?endforeach?>
    </ul>
  </div>
</div>