<?php
/**
 * @var $form \competence\models\test\mailru2013_2\A10
 */

$part1 = $part2 = [];
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
?>

<?foreach ($form->getValues() as $keyTop => $valueTop):?>

  <h4 class="company-large-list"><em><?=$valueTop;?></em></h4>

  <div class="row ib3">
    <div class="span4">
      <ul class="unstyled">
        <?foreach ($part1 as $key => $value):?>
          <li>
            <label class="checkbox">
              <?=CHtml::activeCheckBox($form, 'value['.$keyTop.'][]', ['value' => $key, 'uncheckValue' => null, 'checked' => isset($form->value[$keyTop]) && in_array($key, $form->value[$keyTop]), 'data-group' => 'group'.$keyTop, 'data-unchecker' => (int)($key==90)]);?>
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
              <?=CHtml::activeCheckBox($form, 'value['.$keyTop.'][]', ['value' => $key, 'uncheckValue' => null, 'checked' => isset($form->value[$keyTop]) && in_array($key, $form->value[$keyTop]), 'data-group' => 'group'.$keyTop, 'data-unchecker' => (int)($key==90)]);?>
              <?=$value;?>
            </label>
          </li>
        <?endforeach;?>
      </ul>
    </div>
  </div>

<?endforeach;?>