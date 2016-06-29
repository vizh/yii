<?php
/**
 * @var MainController $this
 * @var \oauth\models\forms\Register $form
 * @var \application\widgets\ActiveForm $activeForm
 */

\Yii::app()->getClientScript()->registerPackage('runetid.jquery.ui');
\Yii::app()->getClientScript()->registerPackage('runetid.jquery.inputmask-multi');
?>
<?php $activeForm = $this->beginWidget('\application\widgets\ActiveForm', ['id' => 'authForm']);?>
<fieldset>
    <legend><?=Yii::t('app', 'Регистрация');?></legend>
    <?=$activeForm->errorSummary($form);?>
    <?if ($form->getSocialProxyIsHasAccess()):?>
        <div class="alert alert-warning">
            Не найдена связь с аккаунтом социальной сети <strong><?=$form->getSocialProxy()->getSocialTitle();?></strong>. Она будет добавлена после регистрации или <?=\CHtml::link('авторизации', ['auth']);?> в RUNET-ID.
        </div>
    <?endif;?>
    <p><?=Yii::t('app', 'Вы&nbsp;можете одновременно получить RUNET-ID и&nbsp;зарегистрироваться на&nbsp;мероприятие, заполнив форму:');?></p>

    <div class="row">
        <div class="col-xs-6">
            <div class="form-group <?=$form->hasErrors('LastName') ? 'has-error' : '';?>">
                <?=$activeForm->textField($form, 'LastName', ['class' => 'form-control', 'placeholder' => $form->getAttributeLabel('LastName')]);?>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group <?=$form->hasErrors('FirstName') ? 'has-error' : '';?>">
                <?=$activeForm->textField($form, 'FirstName', ['class' => 'form-control', 'placeholder' => $form->getAttributeLabel('FirstName')]);?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <?=$activeForm->textField($form, 'FatherName', ['class' => 'form-control', 'placeholder' => $form->getAttributeLabel('FatherName')]);?>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group <?if ($form->Address->hasErrors()):?>has-error<?endif;?>">
                <?$this->widget('\contact\widgets\AddressControls', ['form' => $form->Address, 'address' => false, 'place' => false, 'inputClass' => 'form-control']);?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group <?=$form->hasErrors('Phone') ? 'has-error' : '';?>">
                <?=$activeForm->textField($form, 'Phone', ['class' => 'form-control', 'placeholder' => $form->getAttributeLabel('Phone')]);?>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group <?=$form->hasErrors('Email') ? 'has-error' : '';?>">
                <?=$activeForm->textField($form, 'Email', ['class' => 'form-control', 'placeholder' => $form->getAttributeLabel('Email')]);?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group <?=$form->hasErrors('Company') ? 'has-error' : '';?>">
                <?php $this->widget('\application\widgets\AutocompleteInput', [
                    'model' => $form,
                    'attribute' => 'Company',
                    'label' => $form->Company,
                    'htmlOptions' => ['class' => 'form-control', 'placeholder' => $form->getAttributeLabel('Company')],
                    'source' => $this->createUrl('autocomplete'),
                ]); ?>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group <?=$form->hasErrors('Position') ? 'has-error' : '';?>">
                <?=$activeForm->textField($form, 'Position', ['class' => 'form-control', 'placeholder' => $form->getAttributeLabel('Position')]);?>
            </div>
        </div>
    </div>

    <div class="form-group <?=$form->hasErrors('Captcha') ? 'has-error' : '';?>">
        <div class="g-recaptcha" data-sitekey="6LerUwgTAAAAALjQMLIb1H9zUKHVIGYuK3af5QHj"></div>
    </div>

    <div class="form-group">
        <div class="checkbox">
            <label>
                <?=$activeForm->checkBox($form, 'Subscribe');?> <?=$form->getAttributeLabel('Subscribe');?>
            </label>
        </div>
    </div>

    <p class="muted agreement">Нажимая кнопку «<?=Yii::t('app', 'Зарегистрироваться');?>», я принимаю условия <?=\CHtml::link('Пользовательского соглашения', ['/page/info/agreement'], ['target' => '_blank']);?> и даю своё согласие RUNET-ID на обработку моих персональных данных, в соответствии с Федеральным законом от 27.07.2006 года №152-ФЗ «О персональных данных»</p>

    <button type="submit" class="btn btn-large btn-block btn-primary"><i class="icon-ok-sign icon-white"></i>&nbsp;<?=Yii::t('app', 'Зарегистрироваться');?></button>
</fieldset>
<?php $this->endWidget();?>
<hr>
<p class="text-center"><?=\Yii::t('app', 'Если вы&nbsp;уже получали RUNET-ID&nbsp;&mdash; <a href="{url}">авторизуйтесь</a>.', array('{url}' => $this->createUrl('/oauth/main/auth', \Iframe::isFrame() ? ['frame' => 'true'] : [])));?></p>
