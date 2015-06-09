<?php
/**
 * @var \partner\models\forms\orderitem\Create $form
 * @var $this \partner\components\Controller
 * @var $activeForm CActiveForm
 */

use application\helpers\Flash;

$this->setPageTitle(\Yii::t('app', 'Добавление заказа'));
?>
<?php $activeForm = $this->beginWidget('CActiveForm');?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><span class="fa fa-plus"></span> <?=\Yii::t('app', 'Добавление заказа');?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <?=$activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>');?>
        <?=Flash::html();?>
        <div class="row">
            <div class="col-md-4">
                <?$this->widget('\partner\widgets\UserAutocompleteInput', [
                    'form' => $form,
                    'attribute' => 'Payer'
                ]);?>
            </div>
            <div class="col-md-4">
                <?$this->widget('\partner\widgets\UserAutocompleteInput', [
                    'form' => $form,
                    'attribute' => 'Owner'
                ]);?>
            </div>
            <div class="col-md-4">
                <?=$activeForm->label($form, 'ProductId');?>
                <?=$activeForm->dropDownList($form, 'ProductId', $form->getProductData(), ['class' => 'form-control']);?>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <?=\CHtml::submitButton(\Yii::t('app', 'Создать заказ'), ['class' => 'btn btn-primary']);?>
    </div>
</div>
<?php $this->endWidget();?>

<?/*
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
</div>*/?>
