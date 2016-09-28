<?php
/**
 * @var $question \competence\models\tests\mailru2013\A6
 */
$part1 = $part2 = array();
$i = 0;
$options = $question->getOptions();
$options[99] = 'Затрудняюсь ответить';
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


<h3>Информацию о каких из представленных <strong>компаний</strong> Вы слышали/видели за последний месяц в СМИ?</h3>

<?$this->widget('competence\components\ErrorsWidget', ['question' => $question])?>

<div class="row">
  <div class="span4">
    <ul class="unstyled">
      <?foreach($part1 as $key => $value):?>
      <li>
        <label class="checkbox">
          <?=CHtml::activeCheckBox($question, 'value[]', array('value' => $key, 'uncheckValue' => null, 'checked' => in_array($key, $question->value), 'data-unchecker' => 1, 'data-unchecker-group' => 'group', 'data-unchecker-negative' => (int)($key==99)))?>
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
          <?=CHtml::activeCheckBox($question, 'value[]', array('value' => $key, 'uncheckValue' => null, 'checked' => in_array($key, $question->value), 'data-unchecker' => 1, 'data-unchecker-group' => 'group', 'data-unchecker-negative' => (int)($key==99)))?>
          <?=$value?>
        </label>
      </li>
      <?endforeach?>
    </ul>
  </div>
</div>
