<?php
/**
 * @var $this MainController
 * @var $model \oauth\components\form\RegisterForm
 */
?>

<?php echo CHtml::beginForm();?>
  <fieldset>
    <legend>Регистрация</legend>
    <p>Вы&nbsp;можете одновременно получить RUNET-ID и&nbsp;зарегистрироваться на&nbsp;мероприятие, заполнив форму:</p>
    <div class="control-group <?=$model->hasErrors('LastName') ? 'error' : '';?>">
      <?php echo CHtml::activeTextField($model, 'LastName', array('class' => 'span4', 'placeholder' => $model->getAttributeLabel('LastName')));?>
    </div>
    <div class="control-group <?=$model->hasErrors('FirstName') ? 'error' : '';?>">
      <?php echo CHtml::activeTextField($model, 'FirstName', array('class' => 'span4', 'placeholder' => $model->getAttributeLabel('FirstName')));?>
    </div>
    <div class="control-group">
      <?php echo CHtml::activeTextField($model, 'FatherName', array('class' => 'span4', 'placeholder' => $model->getAttributeLabel('FatherName')));?>
    </div>
    <div class="control-group <?=$model->hasErrors('Email') ? 'error' : '';?>">
      <?php echo CHtml::activeTextField($model, 'Email', array('class' => 'span4', 'placeholder' => $model->getAttributeLabel('Email')));?>
    </div>
    <div class="control-group">
      <?php echo CHtml::activeTextField($model, 'Company', array('class' => 'span4', 'placeholder' => $model->getAttributeLabel('Company')));?>
    </div>
    <div class="control-group">
      <?php echo CHtml::activeTextField($model, 'City', array('class' => 'span4', 'placeholder' => $model->getAttributeLabel('City')));?>
    </div>

    <?php echo CHtml::errorSummary($model, '<div class="alert alert-error m-bottom_20">', '</div>');?>

    <button type="submit" class="btn btn-large btn-block btn-info"><i class="icon-ok-sign icon-white"></i>&nbsp;Зарегистрироваться</button>
  </fieldset>
<?php CHtml::endForm();?>
<hr>
<p>Если вы&nbsp;уже получали RUNET-ID&nbsp;&mdash; <a href="<?=$this->createUrl('/oauth/main/auth');?>">авторизуйтесь</a>.</p>
