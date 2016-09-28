<?php
/**
 * @var $question \competence\models\tests\runet2013\B3_base
 */
?>
<h3>Если принять оборот всех компаний на российском рынке <strong><?=$question->getMarketTitle()?></strong> по итогам 2012 г. за 100%, каким образом он распределился между следующими сегментами?</h3>
<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>


<?foreach($question->getOptions() as $gk=> $list):?>
<h4>
  По типу <?if($gk == 0):?>систем<?else:?>платежей<?endif?>
</h4>
<table class="table">
  <thead>
    <th style="width: 80%">Сегмент рынка</th>
    <th>Доля рынка, %</th>
  </thead>
  <tbody>
    <?foreach($list as $key => $value):?>
    <tr>
      <td><?=$value?></td>
      <td><?=\CHtml::activeTextField($question, 'value['.$key.']', ['class' => 'input-mini', 'value' => !empty($question->value[$key]) ? $question->value[$key] : ''])?> %</td>
    </tr>
    <?endforeach?>
  </tbody>
</table>
<?endforeach?>