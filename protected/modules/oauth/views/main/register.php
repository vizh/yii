<?php echo CHtml::beginForm();?>
  <?php echo CHtml::errorSummary($model, '<div class="alert alert-error m-bottom_20">', '</div>');?>
  <div class="control-group">
    <label class="control-label"><?php echo CHtml::activeLabel($model, 'LastName');?>:</label>
    <div class="controls <?php if($model->hasErrors('LastName')):?>error<?php endif;?>">
      <?php echo CHtml::activeTextField($model, 'LastName');?>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label"><?php echo CHtml::activeLabel($model, 'FirstName');?>:</label>
    <div class="controls <?php if($model->hasErrors('FirstName')):?>error<?php endif;?>">
      <?php echo CHtml::activeTextField($model, 'FirstName');?>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label"><?php echo CHtml::activeLabel($model, 'Email');?>:</label>
    <div class="controls <?php if($model->hasErrors('Email')):?>error<?php endif;?>">
      <?php echo CHtml::activeTextField($model, 'Email');?>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label"><?php echo CHtml::activeLabel($model, 'Password');?>:</label>
    <div class="controls <?php if($model->hasErrors('Password')):?>error<?php endif;?>">
      <?php echo CHtml::activePasswordField($model, 'Password');?>
    </div>
  </div>
  <div class="control-group">
    <div class="controls clearfix">
      <?php echo CHtml::submitButton('Регистрация', array('class' => 'btn btn-success f-left'));?>
      <?php echo CHtml::button('Отмена', array('class' => 'btn btn-cancel'));?>
    </div>
  </div>
<?php CHtml::endForm();?>
