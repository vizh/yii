<?php
/**
 * @var \partner\models\forms\user\Register $form
 * @var \user\models\User $user
 */
?>
<div class="row">
  <div class="span12 indent-bottom3">
    <h2>Регистрация пользователя</h2>
  </div>
</div>

<?if (!empty($user)):?>
  <div class="alert alert-block alert-success">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>Пользователь создан успешно!</h4>
    Перейти к редактированию пользователя: <a target="_blank" href="<?=Yii::app()->createUrl('/partner/user/edit', ['runetId' => $user->RunetId]);?>"><?=$user->RunetId;?></a>
  </div>
<?endif;?>

<?=CHtml::errorSummary($form, '<div class="row"><div class="span12 indent-bottom2"><div class="alert alert-error">', '</div></div></div>');?>

<?=CHtml::beginForm('', 'POST', array('class' => 'form-horizontal'));?>

<div class="row indent-bottom4">
  <div class="span12">
    <div class="control-group">
      <?=CHtml::activeLabel($form, 'LastName', ['class' => 'control-label']);?>
      <div class="controls">
        <?=CHtml::activeTextField($form, 'LastName');?>
      </div>
    </div>
    <div class="control-group">
      <?=CHtml::activeLabel($form, 'FirstName', ['class' => 'control-label']);?>
      <div class="controls">
        <?=CHtml::activeTextField($form, 'FirstName');?>
      </div>
    </div>
    <div class="control-group">
      <?=CHtml::activeLabel($form, 'FatherName', ['class' => 'control-label']);?>
      <div class="controls">
        <?=CHtml::activeTextField($form, 'FatherName');?>
      </div>
    </div>
    <div class="control-group">
      <?=CHtml::activeLabel($form, 'Email', ['class' => 'control-label']);?>
      <div class="controls">
        <?=CHtml::activeTextField($form, 'Email', ['id' => 'Email']);?><span class="help-inline">Оставьте поле пустым для генерации случайного e-mail</span>
      </div>
    </div>

    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'Role', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeDropDownList($form, 'Role', $form->getRoles());?>
      </div>
    </div>
  </div>
</div>

<div class="row indent-bottom4">
  <div class="span6">
    <div class="control-group">
      <?=CHtml::activeLabel($form, 'Company', ['class' => 'control-label']);?>
      <div class="controls">
        <?=CHtml::activeTextField($form, 'Company');?>
      </div>
    </div>
    <div class="control-group">
      <?=CHtml::activeLabel($form, 'Position', ['class' => 'control-label']);?>
      <div class="controls">
        <?=CHtml::activeTextField($form, 'Position');?>
      </div>
    </div>
  </div>
  <div class="span6">
    <div class="control-group">
      <?=CHtml::activeLabel($form, 'Phone', ['class' => 'control-label']);?>
      <div class="controls">
        <?=CHtml::activeTextField($form, 'Phone');?>
      </div>
    </div>

    <div class="control-group">
      <?=CHtml::activeLabel($form, 'City', ['class' => 'control-label']);?>
      <div class="controls">
        <?=CHtml::activeTextField($form, 'City', ['id' => 'City', 'data-source' => Yii::app()->createUrl('/contact/ajax/search')]);?>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="span12">
    <div class="control-group">
      <div class="controls">
        <label class="checkbox"><?=CHtml::activeCheckBox($form, 'Hidden', ['uncheckValue' => null]);?> <?=$form->getAttributeLabel('Hidden');?></label>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="span12">
    <div class="control-group">
      <div class="controls">
        <?=CHtml::submitButton('Зарегистрировать', array('class' => 'btn'));?>
      </div>
    </div>
  </div>
</div>
<?=CHtml::endForm();?>

