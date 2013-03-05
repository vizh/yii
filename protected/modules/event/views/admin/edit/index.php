<div class="btn-toolbar">
  <a href="" class="btn"><?=\Yii::t('app', 'Сохранить');?></a>
</div>
<div class="well">
  <?=\CHtml::form('','POST',array('class' => 'form-horizontal'));?>
  <div class="control-group">
    <?=\CHtml::activeLabel($form, 'IdName', array('class' => 'control-label'));?>
    <div class="controls">
      <?=\CHtml::activeTextField($form, 'IdName');?>
    </div>
  </div>
  <div class="control-group">
    <?=\CHtml::activeLabel($form, 'Title', array('class' => 'control-label'));?>
    <div class="controls">
      <?=\CHtml::activeTextField($form, 'Title');?>
    </div>
  </div>
  <div class="control-group">
    <?=\CHtml::activeLabel($form, 'Info', array('class' => 'control-label'));?>
    <div class="controls controls-row">
      <?=\CHtml::activeTextArea($form, 'Info', array('class' => 'span6'));?>
    </div>
  </div>
  <div class="control-group">
    <?=\CHtml::activeLabel($form, 'FullInfo', array('class' => 'control-label'));?>
    <div class="controls controls-row">
      <?=\CHtml::activeTextArea($form, 'FullInfo', array('class' => 'span6'));?>
    </div>
  </div>
  
  <div class="control-group">
    <?=\CHtml::activeLabel($form, 'Date', array('class' => 'control-label'));?>
    <div class="controls">
      <?=\CHtml::activeTextField($form, 'StartDay', array('class' => 'input-mini'));?>
      <?=\CHtml::activeDropDownList($form, 'StartMonth', \Yii::app()->locale->getMonthNames(), array('class' => 'input-small'));?>
      <?=\CHtml::activeTextField($form, 'StartYear', array('class' => 'input-mini'));?>
      &ndash;
      <?=\CHtml::activeTextField($form, 'EndDay', array('class' => 'input-mini'));?>
      <?=\CHtml::activeDropDownList($form, 'EndMonth', \Yii::app()->locale->getMonthNames(), array('class' => 'input-small'));?>
      <?=\CHtml::activeTextField($form, 'EndYear', array('class' => 'input-mini'));?>
    </div>
  </div>
  
  <div class="control-group">
    <?=\CHtml::activeLabel($form, 'Type', array('class' => 'control-label'));?>
    <div class="controls controls-row">
      <?=\CHtml::activeDropDownList($form, 'TypeId', \CHtml::listData(\event\models\Type::model()->findAll(), 'Id', 'Title'));?>
    </div>
  </div>
  
  <div class="control-group">
    <?=\CHtml::activeLabel($form, 'Visible', array('class' => 'control-label'));?>
    <div class="controls controls-row">
      <?=\CHtml::activeCheckBox($form, 'Visible');?>
    </div>
  </div>
  <div class="control-group">
    <?=\CHtml::activeLabel($form, 'ShowOnMain', array('class' => 'control-label'));?>
    <div class="controls controls-row">
      <?=\CHtml::activeCheckBox($form, 'ShowOnMain');?>
    </div>
  </div>
  <?if ($event->External == true):?>
  <p class="text-warning"><?=\Yii::t('app', 'Внешнее мероприятие');?></p>
  <div class="control-group">
    <?=\CHtml::activeLabel($form, 'Approved', array('class' => 'control-label'));?>
    <div class="controls controls-row">
      <?=\CHtml::activeDropDownList($form, 'Approved', array(
        \event\models\Approved::Yes => \Yii::t('app', 'Принят'),
        \event\models\Approved::None => \Yii::t('app', 'На рассмотрении'),
        \event\models\Approved::No => \Yii::t('app', 'Отклонен')
      ));?>
    </div>
  </div>
  <?endif;?>
  <?=\CHtml::endForm();?>
</div>