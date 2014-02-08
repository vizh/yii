<?php
/**
 * @var \competence\models\Test $test
 * @var int $countFinished
 * @var int $countNotFinished
 */
?>

<div class="well">
  <h2><?=$test->Title;?></h2>

  <p><strong>Всего:</strong> <?=$countFinished+$countNotFinished;?></p>
  <p><strong>Завершено:</strong> <?=$countFinished;?></p>
  <p><strong>Не завершено:</strong> <?=$countNotFinished;?></p>

  <?=\CHtml::form('','POST');?>
  <?=\CHtml::submitButton('Выгрузить результаты', ['class' =>  'btn btn-info']);?>
  <?=\CHtml::endForm();?>
</div>