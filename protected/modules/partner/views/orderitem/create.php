<?php
/**
 * @var \partner\models\forms\orderitem\Create $form
 */
?>
<div class="row">
  <div class="span12 indent-bottom2">
    <h2>Добавление заказа</h2>
  </div>
</div>

<?=CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>

<div class="row">
  <div class="span12">
    <?=CHtml::beginForm('', 'post', array('class' => ' m-top_40'));?>

    <div class="control-group">
      <?=CHtml::activeLabel($form, 'PayerRunetId', array('class' => 'control-label'));?>
      <div class="controls">
        <?$this->widget('\partner\widgets\UserAutocompleteInput', [
          'field' => 'PayerRunetId',
          'form' => $form
        ]);?>
        <p class="help-block">
          <strong>Заметка:</strong> Просто начните набирать фамилию и имя или RUNET-ID пользователя. Здесь автоматически будут отображаться результаты поиска.
        </p>
      </div>
    </div>

    <div class="control-group">
      <?=CHtml::activeLabel($form, 'OwnerRunetId', array('class' => 'control-label'));?>
      <div class="controls">
        <?$this->widget('\partner\widgets\UserAutocompleteInput', [
          'field' => 'OwnerRunetId',
          'form' => $form
        ]);?>
        <p class="help-block">
          <strong>Заметка:</strong> Просто начните набирать фамилию и имя или RUNET-ID пользователя. Здесь автоматически будут отображаться результаты поиска.
        </p>
      </div>
    </div>

    <div class="control-group">
      <?=CHtml::activeLabel($form, 'ProductId', array('class' => 'control-label'));?>
      <div class="controls">
        <?=CHtml::activeDropDownList($form, 'ProductId', $form->getProductData())?>
      </div>
    </div>


    <div class="control-group">
      <div class="controls">
        <div class="row">
          <div class="span3">
            <button type="submit" class="btn btn-info"><?=\Yii::t('app', 'Сохранить')?></button>
          </div>
        </div>
      </div>
    </div>

    <?php echo CHtml::endForm();?>
  </div>
</div>
