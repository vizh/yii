<?
/**
 * @var \pay\models\forms\admin\Acccount $form
 */
?>
<?=\CHtml::form('','POST',['class' => 'form-horizontal', 'enctype' => 'multipart/form-data']);?>
<?=\CHtml::activeHiddenField($form, 'EventId');?>
<div class="btn-toolbar clearfix">
  <a href="<?=$this->createUrl('/pay/admin/account/index');?>" class="btn"><i class="icon-arrow-left"></i> <?=\Yii::t('app', 'Вернуться к списку');?></a>
  <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить изменения'), ['class' => 'btn btn-success pull-right']);?>
</div>
<div class="well">
<?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>
<?if (\Yii::app()->getUser()->hasFlash('success')):?>
  <div class="alert alert-success"><?=\Yii::app()->getUser()->getFlash('success');?></div>
<?endif;?>
<div class="control-group">
  <?=\CHtml::activeLabel($form, 'EventTitle', ['class' => 'control-label']);?>
  <div class="controls">
    <?=\CHtml::activeTextField($form, 'EventTitle', ['readonly' => !$form->getAccount()->getIsNewRecord(), 'class' => 'input-xxlarge']);?>
  </div>
</div>
<div class="control-group">
  <?=\CHtml::activeLabel($form, 'Own', ['class' => 'control-label']);?>
  <div class="controls">
    <?=\CHtml::activeCheckBox($form, 'Own');?>
  </div>
</div>
<div class="control-group">
  <?=\CHtml::activeLabel($form, 'OrderTemplateId', ['class' => 'control-label']);?>
  <div class="controls">
    <?=\CHtml::activeDropDownList($form, 'OrderTemplateId', $form->getOrderTemplateData());?>
  </div>
</div>

<div class="control-group">
  <?=\CHtml::activeLabel($form, 'ReceiptTemplateId', ['class' => 'control-label']);?>
  <div class="controls">
    <?=\CHtml::activeDropDownList($form, 'ReceiptTemplateId', $form->getOrderTemplateData());?>
  </div>
</div>

<div class="control-group">
  <?=\CHtml::activeLabel($form, 'ReturnUrl', ['class' => 'control-label']);?>
  <div class="controls">
    <?=\CHtml::activeTextField($form, 'ReturnUrl', ['class' => 'input-xxlarge']);?>
  </div>
</div>
<div class="control-group">
  <?=\CHtml::activeLabel($form, 'Offer', ['class' => 'control-label']);?>
  <div class="controls">
    <div class="m-bottom_5">
      <?=\CHtml::activeDropDownList($form, 'Offer', $form->getOfferData());?>
    </div>
    <?=\CHtml::activeFileField($form, 'OfferFile');?>
  </div>
</div>
<div class="control-group">
  <?=\CHtml::activeLabel($form, 'OrderLastTime', ['class' => 'control-label']);?>
  <div class="controls">
    <?=\CHtml::activeTextField($form, 'OrderLastTime');?>
  </div>
</div>
<div class="control-group">
  <?=\CHtml::activeLabel($form, 'ReceiptLastTime', ['class' => 'control-label']);?>
  <div class="controls">
    <?=\CHtml::activeTextField($form, 'ReceiptLastTime');?>
  </div>
</div>
<div class="control-group">
  <?=\CHtml::activeLabel($form, 'PaySystem', ['class' => 'control-label']);?>
  <div class="controls">
      <div style="float: left; margin-right: 20px;">
          <label class="checkbox inline">
              <?=\CHtml::activeCheckBox($form, 'Uniteller', ['uncheckValue' => null]);?>
              Uniteller
          </label><br>
          <label class="checkbox inline muted">
              <?=\CHtml::activeCheckBox($form, 'UnitellerRuvents', ['uncheckValue' => null]);?>
              Использовать ООО "РУВЕНТС"
          </label>
      </div>

    <label class="checkbox inline">
      <?=\CHtml::activeCheckBox($form, 'PayOnline', ['uncheckValue' => null]);?>
      PayOnline
    </label>
    <label class="checkbox inline">
      <?=\CHtml::activeCheckBox($form, 'MailRuMoney', ['uncheckValue' => null]);?>
      MailRuMoney
    </label>
  </div>
</div>
</div>
<?=\CHtml::endForm();?>
