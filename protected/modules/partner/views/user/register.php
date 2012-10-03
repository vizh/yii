<script>
  $(function () {
    $('#FormInput_City > input[type="text"]').autocomplete({
      source: '<?php echo $this->createUrl('utility/searchcityajax');?>',
      minLength : 2
    });
    
    $('#FormInput_Company > input[type="text"]').autocomplete({
      source: '<?php echo $this->createUrl('utility/searchcompanyajax');?>',
      minLength : 2
    });
  });
  
</script>

<div class="row">
  <div class="span12 indent-bottom3">
    <h2>Регистрация пользователя</h2>
  </div>
</div>
<?php echo CHtml::errorSummary(
  $model, '<div class="row"><div class="span12 indent-bottom2"><div class="alert alert-error">', '</div></div></div>'
);?>
<div class="row">
  <div class="span12">
    <?php echo CHtml::beginForm('', 'POST', array('class' => 'form-horizontal'));?>
      <div class="control-group">
        <label class="control-label"><?php echo CHtml::activeLabel($model, 'LastName');?></label>
        <div class="controls">
          <?php echo CHtml::activeTextField($model, 'LastName');?>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"><?php echo CHtml::activeLabel($model, 'FirstName');?></label>
        <div class="controls">
          <?php echo CHtml::activeTextField($model, 'FirstName');?>
        </div>
      </div>
      <div class="control-group indent-bottom4">
        <label class="control-label"><?php echo CHtml::activeLabel($model, 'FatherName');?></label>
        <div class="controls">
          <?php echo CHtml::activeTextField($model, 'FatherName');?>
        </div>
      </div>
    
      <div class="control-group">
        <label class="control-label"><?php echo CHtml::activeLabel($model, 'Company');?></label>
        <div class="controls" id="FormInput_Company">
          <?php echo CHtml::activeTextField($model, 'Company');?>
        </div>
      </div>
      <div class="control-group indent-bottom4">
        <label class="control-label"><?php echo CHtml::activeLabel($model, 'Position');?></label>
        <div class="controls">
          <?php echo CHtml::activeTextArea($model, 'Position');?>
        </div>
      </div>
    
      <div class="control-group indent-bottom4">
        <label class="control-label"><?php echo CHtml::activeLabel($model, 'Email');?></label>
        <div class="controls">
          <?php echo CHtml::activeTextField($model, 'Email');?>
        </div>
      </div>
    
      <div class="control-group indent-bottom4">
        <label class="control-label"><?php echo CHtml::activeLabel($model, 'Phone');?></label>
        <div class="controls">
          <?php echo CHtml::activeTextField($model, 'Phone');?>
        </div>
      </div>
      
      <div class="control-group indent-bottom4">
        <label class="control-label"><?php echo CHtml::activeLabel($model, 'City');?></label>
        <div class="controls" id="FormInput_City">
          <?php echo CHtml::activeTextField($model, 'City');?>
        </div>
      </div>
    
      <div class="control-group">
        <div class="controls">
          <?php echo CHtml::submitButton('Зарегистрировать', array('class' => 'btn'));?>
        </div>
      </div>
    <?php echo CHtml::endForm();?>
  </div>
</div>

