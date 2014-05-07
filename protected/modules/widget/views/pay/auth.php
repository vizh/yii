<?/** @var \user\models\forms\Email $tmpUserForm */?>
<div class="container">
  <div class="row-fluid">
    <div class="span6 text-right">
      <p>Для доступа<Br/> к платежному кабинету</p>
      <a href="#" class="btn-info btn" onclick="rID.login(); return false;"><?=\Yii::t('app', 'авторизуйтесь или зарегистрируйтесь.');?></a>
    </div>
    <div class="span6">
      <?= \CHtml::beginForm('','POST',['target'=> '_self']); ?>
      <div class="control-group">
        <label for="<?=\CHtml::activeId($tmpUserForm, 'Email');?>"><?=\Yii::t('app', 'Для создания временного аккаунта введите Email:');?></label>
        <div class="controls">
          <?=\CHtml::errorSummary($tmpUserForm,'<div class="alert alert-error m-bottom_5">', '</div>');?>
          <?=\CHtml::activeTextField($tmpUserForm, 'Email', ['class' => 'input-large']);?>
          <span class="help-block"><?=Yii::t('app', 'На указанный Email будет выслано письмо, с инструкциями по использованию временного аккаунта.');?></span>
        </div>
      </div>
      <button type="submit" class="btn btn-info"><?=Yii::t('app', 'Продолжить');?></button>
      <?= \CHtml::endForm(); ?>
    </div>
  </div>
</div>