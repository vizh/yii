<?php
/**
 * @var $question \competence\models\tests\mailru2013\E1_1
 */
$base = new \competence\models\tests\mailru2013\E1($question->getTest());
$fullData = $question->getFullData();
$baseData = $fullData[get_class($base)];
$baseData['value'][] = 99;
?>

<h3>Какими из перечисленных источников информации Вы пользовались за последний месяц для <strong>получения информации об интернет-отрасли</strong>?<br><span>(Отметьте все подходящие)</span></h3>

<?php $this->widget('competence\components\ErrorsWidget', array('question' => $question));?>

<ul class="unstyled">
  <?foreach ($base->getOptions() as $key => $value):
    if (!in_array($key, $baseData['value']))
    {
      continue;
    }
  ?>
  <li>
    <?if ($key != 10):?>
    <label class="checkbox">
      <?=CHtml::activeCheckBox($question, 'value[]', array('value' => $key, 'uncheckValue' => null, 'checked' => in_array($key, $question->value), 'data-unchecker' => 1, 'data-unchecker-group' => 'group', 'data-unchecker-negative' => (int)($key==99)));?>
      <?=$value;?>
    </label>
    <?else:?>
    <label class="checkbox">
      <?=CHtml::activeCheckBox($question, 'value[]', array('value' => $key, 'uncheckValue' => null, 'checked' => in_array($key, $question->value), 'data-unchecker' => 1, 'data-unchecker-group' => 'group', 'data-unchecker-negative' => (int)($key==99)));?>
      Другое (<em>добавлен свой вариант</em>: <strong><?=$baseData['other'];?></strong>)
    </label>
    <?endif;?>
  </li>
  <?endforeach;?>
</ul>
