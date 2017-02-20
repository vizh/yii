<?php
/**
 * @var $question \competence\models\tests\runet2013\D1
 */
?>
<h3>Перед вами список тенденций, которые могут быть актуальны в российском сегменте <strong><?=$question->getSelectSegmentTitle()?></strong> в течение ближайших пяти лет (до 2018 г.). оцените, насколько существенными будут эти тенденции в указанный период по шкале от 0 (совсем не существенная тенденция) до 10 (очень существенная тенденция).</h3>
<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>
<table class="table">
  <thead>
    <th>Тенденция</th>
    <th>Оценка</th>
  </thead>
  <tbody>
    <?foreach($question->getTrends() as $trend):?>
    <tr>
      <td style="width: 80%;"><?=$trend?></td>
      <td>
        <?=\CHtml::activeDropDownList($question, 'value['.$trend.']', range(0, 10), ['class' => 'input-mini'])?>
      </td>
    </tr>
    <?endforeach?>
  </tbody>
</table>
