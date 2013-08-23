<?php
/**
 * @var $question \competence\models\tests\runet2013\B6_base
 */
?>
<h3>Назовите тройку компаний-лидеров российского рынка <strong><?=$question->getMarketTitle();?></strong> и их примерную долю рынка (в %) на 2012 г.</h3>
<?php $this->widget('competence\components\ErrorsWidget', array('question' => $question));?>
<table class="table">
  <thead>
    <th>№</th>
    <th>Название компании</th>
    <th>Доля рынка, %</th>
  </thead>
  <tbody>
    <?for($i = 1; $i <= 3; $i++):?>
    <tr>
      <td><?=$i;?></td>
      <td><?=\CHtml::activeTextField($question, 'company['.$i.']', ['class' => 'input-xlarge', 'value' => !empty($question->company[$i]) ? $question->company[$i] : '']);?></td>
      <td><?=\CHtml::activeTextField($question, 'percentages['.$i.']', ['class' => 'input-mini', 'value' => !empty($question->percentages[$i]) ? $question->percentages[$i] : '']);?></td>
    </tr>
    <?endfor;?>
  </tbody>
</table>