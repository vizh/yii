<?php

?>

<section id="section" role="main">
  <style>.b-event-promo .side, .b-event-promo .all {display: none;}</style>


  <div class="event-register">
    <div class="container">

      <div class="tabs clearfix">
        <div class="tab pull-left">
          <span class="number img-circle">1</span>
          <?=\Yii::t('pay', 'Регистрация');?>
        </div>
        <div class="tab current pull-left">
          <span class="number img-circle">2</span>
          <?=\Yii::t('pay', 'Оплата');?>
        </div>
      </div>

      <div class="row">
        <div class="span8 offset2">
          <?php echo CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>
          <?php echo CHtml::beginForm('', 'POST', array('class' => ''));?>
          <div class="control-group">
            <?php echo CHtml::activeLabel($form, 'Name', array('class' => 'control-label'));?>
            <div class="controls">
              <?php echo CHtml::activeTextField($form, 'Name', array('class' => 'input-xxlarge'));?>
            </div>
          </div>
          <div class="control-group">
            <?php echo CHtml::activeLabel($form, 'Address', array('class' => 'control-label'));?>
            <div class="controls">
              <?php echo CHtml::activeTextArea($form, 'Address', array('class' => 'input-xxlarge'));?>
            </div>
          </div>
          <div class="control-group">
            <?php echo CHtml::activeLabel($form, 'INN', array('class' => 'control-label'));?>
            <div class="controls">
              <?php echo CHtml::activeTextField($form, 'INN', array('class' => 'input-xxlarge'));?>
            </div>
          </div>
          <div class="control-group">
            <?php echo CHtml::activeLabel($form, 'KPP', array('class' => 'control-label'));?>
            <div class="controls">
              <?php echo CHtml::activeTextField($form, 'KPP', array('class' => 'input-xxlarge'));?>
            </div>
          </div>
          <div class="control-group">
            <?php echo CHtml::activeLabel($form, 'Phone', array('class' => 'control-label'));?>
            <div class="controls">
              <?php echo CHtml::activeTextField($form, 'Phone', array('class' => 'input-xxlarge'));?>
            </div>
          </div>
          <div class="control-group">
            <?php echo CHtml::activeLabel($form, 'Fax', array('class' => 'control-label'));?>
            <div class="controls">
              <?php echo CHtml::activeTextField($form, 'Fax', array('class' => 'input-xxlarge'));?>
            </div>
          </div>
          <div class="control-group">
            <?php echo CHtml::activeLabel($form, 'PostAddress', array('class' => 'control-label'));?>
            <div class="controls">
              <?php echo CHtml::activeTextArea($form, 'PostAddress', array('class' => 'input-xxlarge'));?>
            </div>
          </div>
          <?php echo CHtml::submitButton(\Yii::t('mblt2013', 'Выставить счет'), array('class' => 'btn'));?>
          <?php echo CHtml::endForm();?>
        </div>
      </div>
    </div>
</section>
