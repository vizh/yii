<?php
/**
 * @var $question \competence\models\tests\mailru2013\A6_1
 */
$fullData = $question->getFullData();

$base = new \competence\models\tests\mailru2013\A6($question->getTest());
$baseData = $fullData[get_class($base)];

$base_e1 = new \competence\models\tests\mailru2013\E1_1($question->getTest());
$baseData_e1 = $fullData[get_class($base_e1)];

?>

<h3>В&nbsp;каких источниках Вы&nbsp;видели/слышали о&nbsp;каждой из&nbsp;этих компаний?</h3>

<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>

<ul class="unstyled">
  <?foreach($base->getOptions() as $key => $value):
    if (!in_array($key, $baseData['value']))
    {
      continue;
    }
 ?>
  <li>
    <h4><strong><?=$value?></strong></h4>
    <ul class="unstyled ib4">
    <?foreach((new \competence\models\tests\mailru2013\A5($question->getTest()))->values as $key_1 => $value_1):
      if ($key_1 == 10 && empty($baseData_e1['other']))
      {
        continue;
      }
     ?>
      <li>
        <label class="checkbox">
          <?=CHtml::activeCheckBox($question, 'value['.$key.'][]', array('value' => $key_1, 'uncheckValue' => null, 'checked' => isset($question->value[$key]) && in_array($key_1, $question->value[$key])))?>
          <?if($key_1 != 10):?>
          <?=$value_1?>
          <?else:?>
          Другое (<em>добавлен свой вариант</em>: <strong><?=$baseData_e1['other']?></strong>)
          <?endif?>
        </label>
      </li>
    <?endforeach?>
    </ul>
  </li>
  <?endforeach?>
</ul>