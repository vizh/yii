<?=\CHtml::form('','POST', ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data']);?>
<div class="control-group">
  <?=\CHtml::activeLabel($form, 'BackgroundColor', ['class' => 'control-label']);?>
  <div class="controls">
    # <?=\CHtml::activeTextField($form, 'BackgroundColor');?>
  </div>
</div>
<div class="control-group">
  <?=\CHtml::activeLabel($form, 'BackgroundImage', ['class' => 'control-label']);?>
  <div class="controls">
    <?=\CHtml::activeFileField($form, 'BackgroundImage');?>
    <?if (isset($widget->HeaderBannerBackgroundImagePath)):?>
    <div class="m-top_5">
      <?=\CHtml::image($widget->HeaderBannerBackgroundImagePath,'', ['width' => 500]);?>
    </div>
    <?endif;?>
  </div>
</div>
<div class="control-group">
  <?=\CHtml::activeLabel($form, 'Image', ['class' => 'control-label']);?>
  <div class="controls">
    <?=\CHtml::activeFileField($form, 'Image');?>
    <?if (isset($widget->HeaderBannerImagePath)):?>
    <div class="m-top_5">
      <?=\CHtml::image($widget->HeaderBannerImagePath,'', ['width' => 300]);?>
    </div>
    <?endif;?>
  </div>
</div>
<div class="control-group">
  <?=\CHtml::activeLabel($form, 'Height', ['class' => 'control-label']);?>
  <div class="controls">
    <?=\CHtml::activeTextField($form, 'Height');?>
  </div>
</div>
<div class="control-group">
  <?=\CHtml::activeLabel($form, 'Styles', ['class' => 'control-label']);?>
  <div class="controls">
    <?=\CHtml::activeTextArea($form, 'Styles', ['class' => 'input-block-level']);?>
  </div>
</div>
<div class="control-group">
  <div class="controls">
    <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']);?>
  </div>
</div>
<?=\CHtml::endForm();?>
