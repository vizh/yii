<?php
/**
 * @var $question \competence\models\tests\mailru2013\E3
 */
$fullData = $question->getFullData();
$base = new \competence\models\tests\mailru2013\E1_1($question->getTest());
$baseData = $fullData[get_class($base)];

$manager = \Yii::app()->getAssetManager();
\Yii::app()->getClientScript()->registerScriptFile($manager->publish(\Yii::getPathOfAlias('competence.assets') . '/js/mailru2013/e3.js'), \CClientScript::POS_END);
?>

<h3>Какого рода информацию <strong>об интернет-отрасли</strong> Вы получаете из данных источников?</h3>

<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>

<ul class="unstyled">
  <?foreach($base->getOptions() as $key => $value):
    if (!in_array($key, $baseData['value']))
    {
      continue;
    }
 ?>
  <li>
    <?if($key != 12):?>
    <h4><?=$value?></h4>
    <?else:?>
    <h4>Другое<br>(<em>добавлен свой вариант</em>: <strong><?=$baseData['other']?></strong>)</h4>
    <?endif?>
    <ul class="unstyled">
    <?foreach($question->values as $key_1 => $value_1):?>
      <li>
        <label class="checkbox">
          <?=CHtml::activeCheckBox($question, 'value['.$key.'][]', array('value' => $key_1, 'uncheckValue' => null, 'checked' => !empty($question->value[$key]) && in_array($key_1, $question->value[$key]), 'data-other' => $key_1==6 ? 'checkbox' : '', 'data-other-group' => 'group'.$key))?>
          <?=$value_1?>
        </label>
        <?if($key_1 == 6):?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=CHtml::activeTextField($question, 'other['.$key.']', array('class' => 'span4', 'data-other' => 'input', 'data-other-group' => 'group'.$key, 'disabled' => empty($question->value[$key]) || !in_array($key_1, $question->value[$key])))?>
        <?endif?>
      </li>
    <?endforeach?>
    </ul>
  </li>
  <?endforeach?>
</ul>
