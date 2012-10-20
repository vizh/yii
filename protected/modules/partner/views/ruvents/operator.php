<div class="row">
  <div class="span12 indent-bottom3">
    <h2>Генерация операторов</h2>
  </div>
</div>

<?php echo CHtml::errorSummary(
  $form, '<div class="row"><div class="span12 indent-bottom2"><div class="alert alert-error">', '</div></div></div>'
);?>


<div class="row">
  <div class="span12">
    <?php echo CHtml::beginForm('', 'POST', array('class' => 'form-horizontal'));?>
    <div class="control-group">
      <label class="control-label"><?php echo CHtml::activeLabel($form, 'Prefix');?></label>
      <div class="controls">
        <?php echo CHtml::activeTextField($form, 'Prefix');?>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label"><?php echo CHtml::activeLabel($form, 'CountOperators');?></label>
      <div class="controls">
        <?php echo CHtml::activeTextField($form, 'CountOperators');?>
      </div>
    </div>
    <div class="control-group indent-bottom4">
      <label class="control-label"><?php echo CHtml::activeLabel($form, 'CountAdmins');?></label>
      <div class="controls">
        <?php echo CHtml::activeTextField($form, 'CountAdmins');?>
      </div>
    </div>

    <div class="control-group">
      <div class="controls">
        <?php echo CHtml::submitButton('Сгенерировать', array('class' => 'btn'));?>
      </div>
    </div>
    <?php echo CHtml::endForm();?>
  </div>
</div>

  <div class="row">
    <div class="span12">
      <h3>Ранее генерированные файлы:</h3>
      <?if (!empty($files)):?>
      <ul>
      <?foreach ($files as $file):?>
        <li><?=$file;?></li>
      <?endforeach;?>
      </ul>
      <?endif;?>
    </div>
  </div>
