<?php
/**
 * @var \event\widgets\DetailedRegistration $this
 */
?>
<div class="registration">
    <h5 class="title"><?=Yii::t('app', 'Регистрация');?></h5>
    <?if(\Yii::app()->getUser()->getIsGuest()):?>
    <p>Если вы&nbsp;уже зарегистрированы в&nbsp;<nobr>RUNET-ID</nobr>, <span class="login">войдите в&nbsp;систему</span> под своим аккаунтом для регистрации на&nbsp;Форум &laquo;<nobr>Интернет-предпринимательство</nobr> в&nbsp;России&raquo;.</p>
    <?endif;?>
    <p>Для участия в мероприятии необходимо заполнить все поля формы.</p>

    <?=\CHtml::beginForm('', 'post', ['enctype' => 'multipart/form-data']);?>
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

    <h5>Фото</h5>

    <div class="form-inline m-bottom_5">
        <?if ($this->form->hasPhoto()):?>
            <figure>
                <figcaption>Загруженный файл</figcaption>
                <?=\CHtml::image($this->form->getPhotoUrl(false))?>
            </figure>
        <?endif;?>
        <?=\CHtml::activeFileField($this->form, 'photo', ['class' => 'span12']);?>
        <p style="font-size: 12px; color: #666;">Фотографии должны быть предоставлены в&nbsp;цветном исполнении, размером 30 на&nbsp;40&nbsp;мм, с&nbsp;четким изображением лица, строго в&nbsp;анфас, без головного убора. Размер изображения овала лица на&nbsp;фотографии должен занимать не&nbsp;менее 80 процентов от&nbsp;размера фотографии. Задний фон светлее изображения лица, ровный, без полос, пятен и&nbsp;посторонних предметов.</p>
    </div>

    <div class="form-inline m-top_20">
      <?=\CHtml::submitButton(\Yii::t('app', 'Зарегистрироваться'), ['class' => 'btn btn-info']);?>
    </div>


    <?=\CHtml::endForm();?>
</div>