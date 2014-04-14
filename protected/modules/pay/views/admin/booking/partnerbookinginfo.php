<?/**
 * @var \pay\models\forms\admin\PartnerBookingInfo $form
 * @var \pay\models\RoomPartnerBooking $booking
 * @var string $backUrl
*/?>
<div class="btn-toolbar">
  <?if (!empty($backUrl)):?>
    <a href="<?=$backUrl;?>" class="btn">← <?=\Yii::t('app','Назад');?></a>
  <?endif;?>
</div>
<div class="well">
  <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>
  <?if (\Yii::app()->getUser()->hasFlash('success')):?>
    <div class="alert alert-success"><?=\Yii::app()->getUser()->getFlash('success');?></div>
  <?endif;?>
  <?=\CHtml::form('','POST',['class' => 'form-horizontal']);?>
    <div class="control-group">
      <?=\CHTml::activeLabel($form,'Car',['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHTml::activeTextField($form,'Car[Brand]',['class' => 'input-large m-bottom_5', 'placeholder' => $form->getAttributeLabel('CarBrand')]);?>
        <?=\CHTml::activeTextField($form,'Car[Model]',['class' => 'input-large m-bottom_5', 'placeholder' => $form->getAttributeLabel('CarModel')]);?>
        <?=\CHTml::activeTextField($form,'Car[Number]',['class' => 'input-large m-bottom_5', 'placeholder' => $form->getAttributeLabel('CarNumber')]);?>
      </div>
    </div>

    <div class="control-group">
      <?=\CHTml::activeLabel($form,'People',['class' => 'control-label']);?>
      <div class="controls">
        <?for($i=0;$i<$form->getPeopleCount();$i++):?>
          <?=\CHtml::activeTextField($form,'People['.$i.']',['class' => 'input-block-level m-bottom_5']);?>
        <?endfor;?>
      </div>
    </div>
    <div class="control-group">
      <div class="controls">
        <?=\CHtml::submitButton(\Yii::t('app','Сохранить'), ['class' => 'btn btn-success']);?>
      </div>
    </div>
  <?=\CHtml::endForm();?>
</div>