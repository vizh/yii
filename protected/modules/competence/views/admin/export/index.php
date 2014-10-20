<?php
/**
 * @var \competence\models\Test $test
 * @var int $countFinished
 * @var int $countNotFinished
 */
?>

<div class="well">
  <h2><?=$test->Title;?></h2>

    <?php if (Yii::app()->user->hasFlash('success')):?>
        <div class="alert alert-success">
            <h4>Результаты выгружены!</h4>
            Скачать файл можно с FTP по следующему пути: <?=Yii::app()->user->getFlash('success');?>
        </div>
    <?php endif;?>

  <p><strong>Всего:</strong> <?=$countFinished+$countNotFinished;?></p>
  <p><strong>Завершено:</strong> <?=$countFinished;?></p>
  <p><strong>Не завершено:</strong> <?=$countNotFinished;?></p>

  <?=\CHtml::form('','POST');?>

    <div class="row m-bottom_10">
        <div class="span12">
            <label class="radio inline">
                <input type="radio" name="type" value="all" checked> Все результаты
            </label>
            <label class="radio inline">
                <input type="radio" name="type" value="finished"> Только завершенные
            </label>
            <label class="radio inline">
                <input type="radio" name="type" value="unfinished"> Только не завершенные
            </label>
        </div>
    </div>

    <?=\CHtml::submitButton('Выгрузить результаты', ['class' =>  'btn btn-info']);?>
  <?=\CHtml::endForm();?>
</div>