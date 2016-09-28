<?php
/**
 * @var $error array
 */
?>

<div class="container b-error error-404">
  <div class="cnt">
    <p class="tx"><?=\Yii::t('app','Страница не найдена')?></p>
    <a href="<?=Yii::app()->createUrl('/main/default/index')?>" class="a"><?=\Yii::t('app','Перейдите на главную')?></a>
  </div>
</div>

<hr>
