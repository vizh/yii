<?php
/**
 * @var $form \partner\models\forms\admin\Account
 * @var $account \partner\models\Account
 * @var $password string|null
 */
?>

<?=\CHtml::form('','POST', ['class' => 'form-horizontal'])?>
<?=\CHtml::activeHiddenField($form, 'EventId')?>
<div class="btn-toolbar">
  <a class="btn" href="<?=Yii::app()->createUrl('/partner/admin/account/index')?>"><span class="icon-arrow-left"></span> Назад</a>
  <?if(!$account->getIsNewRecord()):?>
    <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success'])?>
  <?endif?>
</div>

<div class="well">
  <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>')?>
  <?if($password !== null):?>
    <div class="alert alert-success">
      Новый пароль: <strong><?=$password?></strong>
    </div>
  <?endif?>

  <div class="control-group">
    <?=\CHtml::activeLabel($form, 'EventTitle', ['class' => 'control-label'])?>
    <div class="controls">
      <?=\CHtml::activeTextField($form, 'EventTitle', ['class' => 'input-xxlarge', 'readonly' => !$account->getIsNewRecord()])?>
    </div>
  </div>

    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'Role', ['class' => 'control-label'])?>
      <div class="controls">
        <?=CHtml::activeDropDownList($form, 'Role', $form->getRoles())?>
      </div>
    </div>
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'Login', ['class' => 'control-label'])?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'Login', ['class' => 'input-xlarge'])?>
      </div>
    </div>

    <div class="control-group" style="margin-bottom: 0;">
      <div class="controls">
        <?if($account->getIsNewRecord()):?>
          <?=\CHtml::submitButton(\Yii::t('app', 'Создать аккаунт'), ['class' => 'btn btn-success'])?>
        <?else:?>
          <?=\CHtml::submitButton(\Yii::t('app', 'Перегенерировать пароль'), ['class' => 'btn btn-warning', 'id' => 'generatePassword', 'name' => 'generatePassword'])?>
        <?endif?>
      </div>
    </div>

</div>
<?=\CHtml::endForm()?>


