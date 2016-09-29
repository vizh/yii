<?php
/**
 * @var $question \competence\models\tests\mailru2013\A7
 */
$fullData = $question->getFullData();

$base = new \competence\models\tests\mailru2013\A6($question->getTest());
$baseData = $fullData[get_class($base)];

?>


<h3>Вы, упомянули, что видели/слышали информацию о следующих компаниях. Отметьте, пожалуйста, была ли представленная информация… лично для Вас.</h3>

<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>

<ul class="unstyled company-interest-list">
  <?foreach($base->getOptions() as $key => $value):
    if (!in_array($key, $baseData['value']))
    {
      continue;
    }
 ?>
  <li>
    <h4><strong><?=$value?></strong></h4>
    <ul class="unstyled ib3">
    <?foreach($question->values as $key_1 => $value_1):?>
      <li>
        <label class="checkbox">
          <?=CHtml::activeCheckBox($question, 'value['.$key.'][]', array('value' => $key_1, 'uncheckValue' => null, 'checked' => isset($question->value[$key]) && in_array($key_1, $question->value[$key]), 'data-unchecker' => 1, 'data-unchecker-group' => 'group'.$key, 'data-unchecker-negative' => (int)($key_1==9)))?>
          <?=$value_1?>
        </label>
      </li>
    <?endforeach?>
    </ul>
  </li>
  <?endforeach?>
</ul>