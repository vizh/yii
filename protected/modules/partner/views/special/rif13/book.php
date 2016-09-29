<?php
/**
 * @var $datesIn array
 * @var $datesOut array
 * @var $form \partner\models\forms\special\rif13\Book
 * @var $result bool
 */
?>
<div class="row">
  <div class="span12">
    <h2>Интерфейс бронирования</h2>
  </div>
</div>

<?if($form->hasErrors()):?>
  <div class="row">
    <div class="span8 offset2">
      <?=CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>')?>
    </div>
  </div>
<?endif?>

<?if($result !== false):?>
  <div class="row">
    <div class="span8 offset2">
      <div class="alert alert-success">
        <p>Номер успешно забронирован! OrderItem: <?=$result?></p>
      </div>
    </div>
  </div>
<?endif?>

<div class="row">
  <div class="span10 offset1">
    <?=CHtml::beginForm()?>

    <div class="control-group <?=$form->hasErrors('DateIn') ? 'error' : ''?>">
      <?=CHtml::activeLabel($form, 'DateIn')?>
      <?=CHtml::activeDropDownList($form, 'DateIn', $datesIn)?>
    </div>

    <div class="control-group <?=$form->hasErrors('DateOut') ? 'error' : ''?>">
      <?=CHtml::activeLabel($form, 'DateOut')?>
      <?=CHtml::activeDropDownList($form, 'DateOut', $datesOut)?>
    </div>

    <div class="control-group <?=$form->hasErrors('ProductId') ? 'error' : ''?>">
      <?=CHtml::activeLabel($form, 'ProductId')?>
      <?=CHtml::activeTextField($form, 'ProductId')?>
    </div>

    <div class="control-group <?=$form->hasErrors('RunetId') ? 'error' : ''?>">
      <?=CHtml::activeLabel($form, 'RunetId')?>
      <?=CHtml::activeTextField($form, 'RunetId')?>
    </div>

    <div class="control-group <?=$form->hasErrors('BookTime') ? 'error' : ''?>">
      <?=CHtml::activeLabel($form, 'BookTime')?>
      <?=CHtml::activeTextField($form, 'BookTime')?>
    </div>

    <div class="control-group">
      <button class="btn btn-success btn-large" type="submit"><i class="icon-ok icon-white"></i> Бронировать</button>
    </div>


    <?=CHtml::endForm()?>
  </div>
</div>