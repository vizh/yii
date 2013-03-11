<?=\CHtml::form('','POST',array('class' => 'form-horizontal'));?>
<div class="btn-toolbar">
  <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), array('class' => 'btn btn-success'));?>
</div>
<div class="well">
  <div class="row-fluid">
    <div class="span6">
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
        <div class="controls">
          <?=\CHtml::activeDropDownList($form, 'TypeId', \CHtml::listData(\event\models\Type::model()->findAll(), 'Id', 'Title'));?>
        </div>
      </div>

      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'Visible', array('class' => 'control-label'));?>
        <div class="controls">
          <?=\CHtml::activeCheckBox($form, 'Visible');?>
        </div>
      </div>
      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'ShowOnMain', array('class' => 'control-label'));?>
        <div class="controls">
          <?=\CHtml::activeCheckBox($form, 'ShowOnMain');?>
        </div>
      </div>
      <?if ($event->External == true):?>
      <p class="text-warning"><?=\Yii::t('app', 'Внешнее мероприятие');?></p>
      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'Approved', array('class' => 'control-label'));?>
        <div class="controls">
          <?=\CHtml::activeDropDownList($form, 'Approved', array(
            \event\models\Approved::Yes => \Yii::t('app', 'Принят'),
            \event\models\Approved::None => \Yii::t('app', 'На рассмотрении'),
            \event\models\Approved::No => \Yii::t('app', 'Отклонен')
          ));?>
        </div>
      </div>
      <?endif;?>
      
      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'ProfInterest', array('class' => 'control-label'));?>
        <div class="controls">
          <?=\CHtml::activeDropDownList($form, 'ProfInterest', \CHtml::listData(\application\models\ProfessionalInterest::model()->findAll(),'Id','Title'), array('multiple' => true));?>
        </div>
      </div>
    </div>
    
    <div class="span3 event-widgets">
      <?php
      $widgetsAll = array();
      foreach ($widgets->All as $widget):
        $widgetsAll[$widget->getPosition()][] = $widget;
      endforeach;
      ?>
     
      <?foreach ($widgetsAll as $position => $list):?>
        <div class="event-widgets-group">
        <h4>
          <?switch($position):
            case event\components\WidgetPosition::Content:
              echo \Yii::t('app', 'Контентная область');
              break;
            case event\components\WidgetPosition::Header:
              echo \Yii::t('app', 'Шапка');
              break;
            case event\components\WidgetPosition::Sidebar:
              echo \Yii::t('app', 'Левая колонка');
              break;
            case event\components\WidgetPosition::Tabs:
              echo \Yii::t('app', 'Табы');
              break;
          endswitch;?>
        </h4>
        <?foreach ($list as $widget):?>
          <div class="clearfix">
            <div class="pull-left" style="width: 245px;">
              <label class="checkbox"><?=\CHtml::activeCheckBox($form, 'Widgets['.get_class($widget).'][Activated]', array('checked' => isset($widgets->Used[get_class($widget)]) ? true : false));?> <?=$widget->getTitle();?></label>
            </div>
            <div class="pull-right">
              <?php
                if (isset($widgets->Used[get_class($widget)])):
                  $form->Widgets[get_class($widget)]['Order'] = $widgets->Used[get_class($widget)]->Order;
                endif
              ;?>
              <?if ($widget->getAdminPanel() !== NULL):?>
              <a href="" class="btn"><i class="icon-edit"></i></a>
              <?endif;?>
              <?=\CHtml::activeDropDownList($form, 'Widgets['.get_class($widget).'][Order]', array(0,1,2,3,4,5,6,7,8,9,10), array('class' => 'input-mini'));?>
            </div>
          </div>
        <?endforeach;?>
        </div>
      <?endforeach;?>
    </div>
  </div>
</div>
<?=\CHtml::endForm();?>