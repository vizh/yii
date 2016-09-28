<?php
/**
 * @var $question \competence\models\tests\runet2013\D2
 */
?>
<h3>Оцените характер влияния этих тенденций на развитие российского сегмента <strong><?=$question->getSelectSegmentTitle()?></strong> в течение ближайших пяти лет (до 2018 г.). по шкале от -5 (крайне негативное влияние) до +5 (крайне позитивное влияние).</h3>
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
        <?=\CHtml::activeDropDownList($question, 'value['.$trend.']', [-5 =>-5,-4=>-4,-3=>-3,-2=>-2,-1=>-1,0=>0,1=>1,2=>2,3=>3,4=>4,5=>5], ['class' => 'input-mini'])?>
      </td>
    </tr>
    <?endforeach?>
  </tbody>
</table>
