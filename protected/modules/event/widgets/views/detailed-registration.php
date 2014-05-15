<?php
/**
 * @var \event\widgets\DetailedRegistration $this
 */
?>
<div class="registration">
    <h5 class="title"><?=Yii::t('app', 'Регистрация');?></h5>

    <p>Для участия в мероприятии необходимо заполнить все поля формы.</p>

    <?=\CHtml::beginForm('', 'post', []);?>
    <?=\CHtml::errorSummary($this->form, '<div class="alert alert-error">', '</div>');?>

    <h5>Основная информация</h5>
    <div class="form-inline row-fluid m-bottom_20">

        <?=\CHtml::activeTextField($this->form, 'email', ['class' => 'span6', 'placeholder' => $this->form->getAttributeLabel('email'), 'disabled' => $this->form->isDisabled('email')]);?>

        <?if ($this->form->hasErrors('password')):?>
        <?=\CHtml::activePasswordField($this->form, 'password', ['class' => 'span6', 'placeholder' => $this->form->getAttributeLabel('password')]);?>
        <?endif;?>
    </div>

    <div class="form-inline row-fluid m-bottom_20">

        <?=\CHtml::activeTextField($this->form, 'lastName', ['class' => 'span6 m-bottom_5', 'placeholder' => $this->form->getAttributeLabel('lastName'), 'disabled' => $this->form->isDisabled('lastName')]);?>

        <?=\CHtml::activeTextField($this->form, 'firstName', ['class' => 'span6 m-bottom_5', 'placeholder' => $this->form->getAttributeLabel('firstName'), 'disabled' => $this->form->isDisabled('firstName')]);?>

        <?=\CHtml::activeTextField($this->form, 'fatherName', ['class' => 'span6', 'placeholder' => $this->form->getAttributeLabel('fatherName'), 'disabled' => $this->form->isDisabled('fatherName')]);?>

    </div>

    <div class="form-inline row-fluid m-bottom_5">

        <?=\CHtml::activeTextField($this->form, 'company', ['class' => 'span6', 'placeholder' => $this->form->getAttributeLabel('company')]);?>
        <?=\CHtml::activeTextField($this->form, 'position', ['class' => 'span6', 'placeholder' => $this->form->getAttributeLabel('position')]);?>

    </div>

    <div class="form-inline row-fluid m-bottom_5">
        <?$this->widget('\contact\widgets\PhoneControls', ['form' => $this->form->phone, 'inputClass' => 'span6']);?>
    </div>
    <div class="form-inline row-fluid m-bottom_5">
        <?$this->widget('\contact\widgets\AddressControls', ['form' => $this->form->address, 'address' => false, 'place' => false, 'inputClass' => 'span6']);?>

    </div>

    <h5>Паспортные данные</h5>

    <div class="form-inline m-bottom_5">
        <?=\CHtml::activeTextField($this->form, 'birthday', ['class' => 'span2', 'placeholder' => $this->form->getAttributeLabel('birthday')]);?>
        <?=\CHtml::activeTextField($this->form, 'birthPlace', ['class' => 'span3', 'placeholder' => $this->form->getAttributeLabel('birthPlace')]);?>
    </div>

    <div class="form-inline m-bottom_5">
        <?=\CHtml::activeTextField($this->form, 'passportSerial', ['class' => 'span2', 'placeholder' => $this->form->getAttributeLabel('passportSerial')]);?>
        <?=\CHtml::activeTextField($this->form, 'passportNumber', ['class' => 'span3', 'placeholder' => $this->form->getAttributeLabel('passportNumber')]);?>
    </div>

    <div class="form-inline m-top_20">
        <?=\CHtml::submitButton(\Yii::t('app', 'Зарегистрироваться'), ['class' => 'btn btn-info']);?>
    </div>


    <?=\CHtml::endForm();?>
</div>