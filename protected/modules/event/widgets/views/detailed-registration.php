<?php
/**
 * @var \event\widgets\DetailedRegistration $this
 * @var \event\models\UserData $userData
 */
use \application\components\attribute\BooleanDefinition;
?>
<div class="registration">
    <?if (isset($this->RegistrationBeforeInfo)):?>
        <?=$this->RegistrationBeforeInfo;?>
    <?endif;?>
    <h5 class="title"><?=Yii::t('app', 'Регистрация');?></h5>
    <?=\CHtml::beginForm('', 'post', ['enctype' => 'multipart/form-data']);?>
    <?=\CHtml::errorSummary($this->form, '<div class="alert alert-error">', '</div>');?>

    <?if (!$this->form->hasErrors('Invite')):?>
    <div class="form-inline row-fluid m-bottom_5">
        <div class="span6">
            <?=\CHtml::activeTextField($this->form, 'Email', ['class' => 'span12', 'placeholder' => $this->form->getAttributeLabel('Email'), 'disabled' => $this->form->isDisabled('Email')]);?>
        </div>
        <div class="span6">
            <?=\CHtml::activeTextField($this->form, 'PrimaryPhone', ['class' => 'span12', 'placeholder' => $this->form->getAttributeLabel('PrimaryPhone'), 'disabled' => $this->form->isDisabled('PrimaryPhone')]);?>
        </div>
        <?if ($this->form->hasErrors('Password')):?>
            <?=\CHtml::activePasswordField($this->form, 'Password', ['class' => 'span6 m-top_5', 'placeholder' => $this->form->getAttributeLabel('Password')]);?>
        <?endif;?>
    </div>

    <div class="form-inline row-fluid">
        <div class="span6"><?=\CHtml::activeTextField($this->form, 'LastName', ['class' => 'span12 m-bottom_5', 'placeholder' => $this->form->getAttributeLabel('LastName'), 'disabled' => $this->form->isDisabled('LastName')]);?></div>
        <div class="span6"><?=\CHtml::activeTextField($this->form, 'FirstName', ['class' => 'span12 m-bottom_5', 'placeholder' => $this->form->getAttributeLabel('FirstName'), 'disabled' => $this->form->isDisabled('FirstName')]);?></div>
    </div>

    <div class="form-inline row-fluid">
        <div class="span6"><?=\CHtml::activeTextField($this->form, 'FatherName', ['class' => 'span12 m-bottom_5', 'placeholder' => $this->form->getAttributeLabel('FatherName'), 'disabled' => $this->form->isDisabled('FatherName')]);?></div>
        <div class="span6">
            <?$this->widget('\contact\widgets\AddressControls', ['form' => $this->form->Address, 'inputClass' => 'span12', 'place' => false, 'address' => false, 'disabled' => $this->form->isDisabled('LinkAddress')]);?>
        </div>
    </div>

    <div class="form-inline row-fluid">
        <div class="span6"><?=\CHtml::activeTextField($this->form, 'Birthday', ['class' => 'span12 m-bottom_5', 'placeholder' => $this->form->getAttributeLabel('Birthday').'. '.\Yii::t('app', 'Пример: 01.01.1980'), 'disabled' => $this->form->isDisabled('Birthday')]);?></div>
    </div>
    <hr/>

    <?if ($this->ShowEmployment):?>
    <div class="form-inline row-fluid m-bottom_5">
        <div class="span6"><?=\CHtml::activeTextField($this->form, 'Company', ['class' => 'span12', 'placeholder' => $this->form->getAttributeLabel('Company')]);?></div>
        <div class="span6"><?=\CHtml::activeTextField($this->form, 'Position', ['class' => 'span12', 'placeholder' => $this->form->getAttributeLabel('Position')]);?></div>
    </div>
    <hr/>
    <?endif;?>

    <?foreach($this->userData->getManager()->getDefinitions() as $definition):?>
    <div class="form-inline row-fluid m-bottom_10">
        <div class="span12">
            <?if (isset($this->ShowUserDataLabel) && $this->ShowUserDataLabel):?>
                <label class="control-label"><?=$definition->title;?></label>
                <?=$definition->activeEdit($this->userData->getManager(), ['class' => ($definition instanceof BooleanDefinition) ? '' : 'span12']);?>
            <?else:?>
                <?=$definition->activeEdit($this->userData->getManager(), ['placeholder' => $definition->title, 'class' => ($definition instanceof BooleanDefinition) ? '' : 'span12']);?>
            <?endif;?>
        </div>
    </div>
    <?endforeach;?>


    <div class="form-user-register" style="padding: 0;">
        <small class="muted required-notice">
            <span class="required-asterisk">*</span> &mdash; <?=\Yii::t('registration', 'все поля обязательны для заполнения');?>
        </small>
    </div>

    <div class="form-inline m-top_20 text-center">
        <?=\CHtml::submitButton(\Yii::t('app', 'Зарегистрироваться'), ['class' => 'btn btn-info']);?>
    </div>
    <?endif;?>
    <?=\CHtml::endForm();?>
</div>