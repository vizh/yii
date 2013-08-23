<?php
/**
 * @var $question \competence\models\tests\runet2013\D6
 */
?>
<h3>Согласно результатам международного исследования бостонской консалтинговой группы, в 2010 г. доля онлайн экономики от ввп в среднем по 50 исследуемым странам с наибоее развитой онлайн экономикой составила 4%. в россии данный показатель оказался равен 2%. какой из приведенных ниже прогнозов на 2018 г., на ваш взгляд, представляется наиболее вероятным?</h3>
<?php $this->widget('competence\components\ErrorsWidget', array('question' => $question));?>
<?foreach ($question->getOptions() as $key => $option):?>
<div class="form-inline m-bottom_5">
  <label class="radio">
    <?=CHtml::activeRadioButton($question, 'value', ['value' => $key, 'uncheckValue' => null]);?>
    <?=$option;?>
  </label>
</div>
<?endforeach;?>


