<?php
/**
 * @var $form \competence\models\test\mailru2013_2\A6
 */
$part1 = $part2 = array();
$i = 0;
$options = $form->getOptions();
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

<div class="row">
  <div class="span4">
    <ul class="unstyled">
      <?foreach ($part1 as $key => $value):?>
      <li>
        <label class="checkbox">
          <?=CHtml::activeCheckBox($form, 'value[]', array('value' => $key, 'uncheckValue' => null, 'checked' => in_array($key, $form->value), 'data-group' => $form->getQuestion()->Code, 'data-unchecker' => (int)($key==99)));?>
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
          <?=CHtml::activeCheckBox($form, 'value[]', array('value' => $key, 'uncheckValue' => null, 'checked' => in_array($key, $form->value), 'data-group' => $form->getQuestion()->Code, 'data-unchecker' => (int)($key==99)));?>
          <?=$value;?>
        </label>
      </li>
      <?endforeach;?>
    </ul>
  </div>
</div>
