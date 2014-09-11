<?php
/**
 * @var \event\widgets\DetailedRegistration $this
 */

?>
<div class="registration">
    <h5 class="title"><?=Yii::t('app', 'Регистрация');?></h5>

    <p><?=Yii::t('registration', 'Вы можете бесплатно зарегистрироваться на мероприятие «Следуй за АЛД Автомотив или новое прочтение классики» со статусом «Участник».');?></p>

    <p><?=Yii::t('registration', 'Нажимая кнопку «Зарегистрироваться» вы подтверждаете свое участие в мероприятие 2 октября 2014, которое состоится по адресу г. Москва, Смоленская пл., д. 3, Ресторан «White Rabbit»');?></p>

    <?=\CHtml::beginForm('', 'post', ['enctype' => 'multipart/form-data']);?>
    <?=\CHtml::errorSummary($this->form, '<div class="alert alert-error">', '</div>');?>

    <h5><?=Yii::t('registration', 'Основная информация');?></h5>
    <div class="form-inline row-fluid m-bottom_5">

        <div class="span6">
            <?=\CHtml::activeTextField($this->form, 'email', ['class' => 'span12', 'placeholder' => $this->form->getAttributeLabel('email'), 'disabled' => $this->form->isDisabled('email')]);?>
        </div>



        <div class="span6">
            <?$this->widget('\contact\widgets\PhoneControls', ['form' => $this->form->phone, 'inputClass' => 'span12', 'disabled' => $this->form->isDisabled('primaryPhone')]);?>
        </div>


        <?if ($this->form->hasErrors('password')):?>
        <?=\CHtml::activePasswordField($this->form, 'password', ['class' => 'span6 m-top_5', 'placeholder' => $this->form->getAttributeLabel('password')]);?>
        <?endif;?>
    </div>

    <div class="form-inline row-fluid m-bottom_20">

        <div class="span6"><?=\CHtml::activeTextField($this->form, 'lastName', ['class' => 'span12 m-bottom_5', 'placeholder' => $this->form->getAttributeLabel('lastName'), 'disabled' => $this->form->isDisabled('lastName')]);?></div>


        <div class="span6"><?=\CHtml::activeTextField($this->form, 'firstName', ['class' => 'span12 m-bottom_5', 'placeholder' => $this->form->getAttributeLabel('firstName'), 'disabled' => $this->form->isDisabled('firstName')]);?></div>


    </div>

    <div class="form-inline row-fluid m-bottom_5">

        <div class="span6"><?=\CHtml::activeTextField($this->form, 'company', ['class' => 'span12', 'placeholder' => $this->form->getAttributeLabel('company')]);?></div>


        <div class="span6"><?=\CHtml::activeTextField($this->form, 'position', ['class' => 'span12', 'placeholder' => $this->form->getAttributeLabel('position')]);?></div>


    </div>

    <div class="form-user-register" style="padding: 0;">
        <small class="muted required-notice">
            <span class="required-asterisk">*</span> &mdash; <?=\Yii::t('registration', 'все поля обязательны для заполнения');?>
        </small>
    </div>

    <div class="form-inline m-top_20">
        <?=\CHtml::submitButton(\Yii::t('app', 'Зарегистрироваться'), ['class' => 'btn btn-info']);?>
    </div>


    <?=\CHtml::endForm();?>


</div>