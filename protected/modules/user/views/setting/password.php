<?=$this->renderPartial('parts/title')?>
<div class="user-account-settings">
  <div class="clearfix">
    <div class="container">
      <div class="row">
        <div class="span3">
          <?=$this->renderPartial('parts/nav', array('current' => $this->getAction()->getId()))?>
        </div>
        <div class="span9">
          <?=\CHtml::beginForm('', 'POST', array('class' => 'b-form'))?>
            <div class="form-header">
              <h4><?=\Yii::t('app', 'Смена пароля')?></h4>
            </div>
            <?=$this->renderPartial('user.views.edit.parts.form-alert', array('form' => $form))?>

            <div class="form-row">
              <?=\CHtml::activeLabel($form, 'OldPassword')?>
              <?=\CHtml::activePasswordField($form, 'OldPassword', array('class' => 'span5', 'required' => true))?>
            </div>

            <div class="form-row">
              <?=\CHtml::activeLabel($form, 'NewPassword1')?>
              <?=\CHtml::activePasswordField($form, 'NewPassword1', array('class' => 'span5', 'required' => true))?>
            </div>

            <div class="form-row">
              <?=\CHtml::activeLabel($form, 'NewPassword2')?>
              <?=\CHtml::activePasswordField($form, 'NewPassword2', array('class' => 'span5', 'required' => true))?>
            </div>

            <div class="form-info"><b><span class="required">*</span></b> — <?=\Yii::t('app', 'поля обязательны для заполнения')?></div>

            <div class="form-footer">
              <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), array('class' => 'btn btn-info'))?>
            </div>
          <?=\CHtml::endForm()?>
        </div>
      </div>
    </div>
  </div>
</div>