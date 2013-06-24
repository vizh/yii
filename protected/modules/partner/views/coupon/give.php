<?php
/**
 * @var $coupons \pay\models\Coupon[]
 */
?>
<div class="row">
  <div class="span12 m-bottom_30">
    <h2><?=\Yii::t('app', 'Выдача промо-кодов');?></h2>
  </div>
</div>
<?=\CHtml::beginForm('', 'POST');?>
<div class="row">
  <div class="span12">
    <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>
    <?if (\Yii::app()->getUser()->hasFlash('success')):?>
      <div class="alert alert-success"><?=\Yii::app()->getUser()->getFlash('success');?></div>
    <?endif;?>
    
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'Recipient', array('class' => 'control-label'));?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'Recipient', array('class' => 'input-block-level'));?>
      </div>
    </div>
    <div class="control-group">
      <div class="controls">
        <?=\CHtml::submitButton(\Yii::t('app', 'Выдать'), array('class' => 'btn'));?>
      </div>
    </div>
  </div>
</div>
<?=\CHtml::endForm();?>



<div class="row">
  <div class="span5">
    <table class="table table-striped">
      <thead>
      <th><?=\Yii::t('app','Купон');?></th>
      <th><?=\Yii::t('app','Скидка');?></th>
      <th><?=\Yii::t('app','Статус');?></th>
      </thead>
      <tbody>
      <?foreach ($coupons as $coupon):?>
        <tr>
          <td><?php echo  $coupon->Code;?></td>
          <td><?php echo ($coupon->Discount * 100);?>%</td>
          <td>
            <?php if (empty($coupon->Recipient)):?>
              <span class="label label-success"><?=\Yii::t('app','Свободен');?></span>
            <?php else:?>
              <span class="label label-important" title="<?php echo $coupon->Recipient;?>"><?=\Yii::t('app','Выдан');?></span>
            <?php endif;?>
          </td>
        </tr>
      <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>