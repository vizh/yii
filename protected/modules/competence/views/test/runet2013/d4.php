<?php
/**
 * @var $question \competence\models\tests\runet2013\D4
 */
?>
<h3>Оцените характер влияния этих факторов на развитие российского сегмента <strong><?=$question->getSelectSegmentTitle()?></strong> в течение ближайших пяти лет (до 2018 г.). по шкале от -5 (крайне негативное влияние) до +5 (крайне позитивное влияние).</h3>
<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>
<table class="table">
  <thead>
    <th>Фактор</th>
    <th>Оценка</th>
  </thead>
  <tbody>
    <?foreach($question->getFactors() as $factor):?>
    <tr>
      <td style="width: 80%;"><?=$factor?></td>
      <td>
        <?=\CHtml::activeDropDownList($question, 'value['.$factor.']', [-5 =>-5,-4=>-4,-3=>-3,-2=>-2,-1=>-1,0=>0,1=>1,2=>2,3=>3,4=>4,5=>5], ['class' => 'input-mini'])?>
      </td>
    </tr>
    <?endforeach?>
  </tbody>
</table>
