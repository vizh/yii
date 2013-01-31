<?php echo CHtml::beginForm();?>
  <?php echo CHtml::errorSummary($model, '<div class="alert alert-error m-bottom_20">', '</div>');?>
  <div class="control-group">
    <label class="control-label"><?php echo CHtml::activeLabel($model, 'RocIdOrEmail');?>:</label>
    <div class="controls">
      <?php echo CHtml::activeTextField($model, 'RocIdOrEmail');?>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label"><?php echo CHtml::activeLabel($model, 'Password');?>:</label>
    <div class="controls">
      <?php echo CHtml::activePasswordField($model, 'Password');?>
    </div>
  </div>
  <div class="control-group">
    <div class="controls clearfix">
      <?php echo CHtml::submitButton('Войти', array('class' => 'btn btn-success f-left'));?>
      <?php echo CHtml::button('Отмена', array('class' => 'btn btn-cancel'));?>
    </div>
  </div>
<?php CHtml::endForm();?>

<a href="<?=$fbUrl;?>">Фейсбук</a> &nbsp;&nbsp;&nbsp;&nbsp;  <a href="<?=$twiUrl;?>">Твиттер</a>