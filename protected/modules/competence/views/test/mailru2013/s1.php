<?php
/**
 * @var $question \competence\models\questions\s\S1
 */
?>

<h3>Отметьте, пожалуйста, какое из высказываний лучше всего подходит для описания Вашего рода деятельности.</h3>

<?$this->widget('competence\components\ErrorsWidget', array('question' => $question))?>

<ul class="unstyled">
  <li>
    <label class="radio">
      <?=CHtml::activeRadioButton($question, 'value', array('value' => 1, 'uncheckValue' => null))?>
      Я работаю в интернет-компании
    </label>
  </li>
  <li>
    <label class="radio">
      <?=CHtml::activeRadioButton($question, 'value', array('value' => 2, 'uncheckValue' => null))?>
      Я не работаю в интернет-компании, но мои профессиональные интересы связаны с интернет-отраслью (работаю в качестве журналиста, PR-специалиста и т.п.)
    </label>
  </li>
  <li>
    <label class="radio">
      <?=CHtml::activeRadioButton($question, 'value', array('value' => 3, 'uncheckValue' => null))?>
      Я не работаю в интернет-компании и мои профессиональные интересы не связаны с этой отраслью
    </label>
  </li>
</ul>
