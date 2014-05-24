<?php
/**
 * @var \partner\models\forms\OperatorGenerate $form
 * @var \ruvents\models\Account $account
 * @var \ruvents\models\Operator[] $operators
 */
?>
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
    <h3>Хэш клиента</h3>
    <code style="font-size: 16px;"><?=$account->Hash;?></code>
  </div>
</div>

<div class="row">
  <div class="span12">
    <h3>Ранее генерированные операторы:</h3>
    <table class="table">
      <thead>
      <tr>
        <th>Логин</th>
        <th>Пароль</th>
        <th>Роль</th>
      </tr>
      </thead>
      <tbody>
      <?foreach ($operators as $operator):?>
        <tr>
          <td><?=$operator->Login;?></td>
          <td><?=$operator->Password;?></td>
          <td><?=$operator->Role;?></td>
        </tr>
      <?endforeach;?>
      </tbody>
    </table>
  </div>
</div>

<div class="row">
    <div class="span12 m-bottom_40">
        <h3>QR-код для мобильного приложения</h3>
        <img src="<?=Yii::app()->createUrl('/partner/ruvents/mobile');?>" alt=""/>
        <a target="_blank" href="<?=Yii::app()->createUrl('/partner/ruvents/mobile');?>">Открыть в новом окне</a>
    </div>
</div>
