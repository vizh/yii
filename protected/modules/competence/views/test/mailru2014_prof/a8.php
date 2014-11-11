<?php
/**
 * @var $form \competence\models\test\mailru2013_2\A8
 */

$part1 = $part2 = array();
$i = 0;
foreach ($form->getOptions() as $key => $value)
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

function getAttrs(\competence\models\test\mailru2014_prof\A8 $form, $key)
{
  $attrs = [
    'value' => $key,
    'uncheckValue' => null,
    'data-group' => $form->getQuestion()->Code,
    'data-unchecker' => (int)($key==99),
    'checked' => in_array($key, $form->value)
  ];
  if ($key == 98)
  {
    $attrs['data-target'] = '#'.$form->getQuestion()->Code.'_'.$key;
  }
  return $attrs;
}
?>
<div class="row">
  <div class="span4">
    <ul class="unstyled">
      <?foreach ($part1 as $key => $value):?>
      <li>
        <label class="checkbox">
          <?=CHtml::activeCheckBox($form, 'value[]', getAttrs($form, $key));?>
          <?=$value;?>
        </label>
        <?if ($key == 98):?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=CHtml::activeTextField($form, 'other', ['class' => 'span4', 'data-group' => $form->getQuestion()->Code, 'id' => $form->getQuestion()->Code.'_'.$key]);?>
        <?endif;?>
      </li>
      <?endforeach;?>
    </ul>
  </div>
  <div class="span5">
    <ul class="unstyled">
      <?foreach ($part2 as $key => $value):?>
      <li>
        <label class="checkbox">
          <?=CHtml::activeCheckBox($form, 'value[]', getAttrs($form, $key));?>
          <?=$value;?>
        </label>
        <?if ($key == 98):?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=CHtml::activeTextField($form, 'other', ['class' => 'span4', 'data-group' => $form->getQuestion()->Code, 'id' => $form->getQuestion()->Code.'_'.$key]);?>
        <?endif;?>
      </li>
      <?endforeach;?>
    </ul>
  </div>
</div>

