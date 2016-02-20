<?php
/**
 * @var event\widgets\DetailedRegistration $this
 * @var event\models\UserData $userData
 */
?>
<div class="registration" id="<?=$this->getNameId();?>">
    <?=isset($this->WidgetRegistrationTitle) ?
        $this->WidgetRegistrationTitle :
        CHtml::tag('h5', ['class' => 'title text-center'], Yii::t('app', 'Регистрация'))
    ?>

    <?php if (isset($this->WidgetRegistrationBeforeInfo)): ?>
        <?=$this->WidgetRegistrationBeforeInfo?>
    <?php endif ?>

    <?=CHtml::beginForm('', 'post', ['enctype' => 'multipart/form-data']);?>
    <?=CHtml::errorSummary($this->form, '<div class="alert alert-error">', '</div>');?>

    <?php if (!$this->form->hasErrors('Invite')): ?>
        <?php $this->render('detailed-registration/appeal-for-ipheb16') ?>

        <?php $this->render('detailed-registration/primary-fields') ?>

        <hr>

        <?php $this->render('detailed-registration/extended-user-data') ?>
        <?php $this->render('detailed-registration/roles') ?>

        <div class="form-user-register" style="padding: 0;">
            <small class="muted required-notice">
                <span class="required-asterisk">*</span> &mdash; <?=Yii::t('registration', 'все поля обязательны для заполнения');?><br/>
                <span class="required-asterisk">**</span> &mdash; <?=Yii::t('registration', 'заполняя анкету, я принимаю условия соглашения  на хранение и обработку персональных данных');?>
            </small>
        </div>

        <div class="form-inline m-top_20 text-center">
            <?=CHtml::submitButton(
                Yii::t('app', (isset($this->WidgetRegistrationDetailedSubmitButtonLabel) ? $this->WidgetRegistrationDetailedSubmitButtonLabel : 'Зарегистрироваться')), ['class' => 'btn btn-info']
            )?>
        </div>
    <?php endif ?>

    <?=CHtml::endForm()?>
</div>