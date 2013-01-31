<?php echo CHtml::beginForm();?>
<div class="clearfix m-bottom_20">
  <div class="f-left m-right_20">
    <img src="<?php echo $user->GetMiniPhoto();?>" />
  </div>
  <h3 class="u-name"><?php echo $user->GetFullName();?></h3>
  <?php $employment = $user->GetPrimaryEmployment();?>
  <?php if ($employment !== null):?>
    <?php echo $employment->Company->Name;?><?php if (!empty($employment->Position)):?>, <?php echo $employment->Position;?><?php endif;?></p>
  <?php endif;?>
</div>
<p><strong>«<?php echo $event->Name;?>»</strong> заправшивает доступ к Вашим данным</p>
<div class="clearfix m-top_20">
  <?php echo CHtml::submitButton('Разрешить', array('class' => 'btn btn-success f-left m-right_20'));?>
  <?php echo CHtml::button('Отмена', array('class' => 'btn btn-cancel'));?>
</div>
<?php echo CHtml::endForm();?>