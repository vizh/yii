<?php
/**
 * @var $question \competence\models\tests\mailru2013\A10_1
 */

$part1 = $part2 = array();
$i = 0;
foreach ((new \competence\models\tests\mailru2013\A10($question->getTest()))->getOptions() as $key => $value)
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

<h3>Перед Вами высказывания, касающиеся <nobr>интернет-компаний</nobr>. Отметьте, пожалуйста, для каждого высказывания, какие компании соответствуют данному высказыванию. Помните, для каждого высказывания Вы&nbsp;можете выбрать одну компанию или несколько или отметить &laquo;Не&nbsp;подходит ни&nbsp;к&nbsp;одной компании&raquo; <strong>Часть 2.</strong></h3>

<?php $this->widget('competence\components\ErrorsWidget', array('question' => $question));?>

<?foreach ($question->getValues() as $keyTop => $valueTop):?>

  <h4 class="company-large-list"><em><?=$valueTop;?></em></h4>

<div class="row ib3">
  <div class="span4">
    <ul class="unstyled">
      <?foreach ($part1 as $key => $value):?>
      <li>
        <label class="checkbox">
          <?=CHtml::activeCheckBox($question, 'value['.$keyTop.'][]', array('value' => $key, 'uncheckValue' => null, 'checked' => isset($question->value[$keyTop]) && in_array($key, $question->value[$keyTop]), 'data-unchecker' => 1, 'data-unchecker-group' => 'group'.$keyTop, 'data-unchecker-negative' => (int)($key==90)));?>
          <?=$value;?>
        </label>
      </li>
      <?endforeach;?>
    </ul>
  </div>
  <div class="span5">
    <ul class="unstyled">
      <?foreach ($part2 as $key => $value):?>
      <li>
        <label class="checkbox">
          <?=CHtml::activeCheckBox($question, 'value['.$keyTop.'][]', array('value' => $key, 'uncheckValue' => null, 'checked' => isset($question->value[$keyTop]) && in_array($key, $question->value[$keyTop]), 'data-unchecker' => 1, 'data-unchecker-group' => 'group'.$keyTop, 'data-unchecker-negative' => (int)($key==90)));?>
          <?=$value;?>
        </label>
      </li>
      <?endforeach;?>
    </ul>
  </div>
</div>

<?endforeach;?>