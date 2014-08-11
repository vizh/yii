<?php
/**
 * @var $this MainController
 * @var $model \oauth\components\form\RegisterForm
 */
?>

<?=CHtml::beginForm();?>
  <fieldset>
    <legend><?=Yii::t('app', 'Регистрация');?></legend>

    <?if ($socialProxy !== null && $socialProxy->isHasAccess()):?>
      <div class="alert alert-warning">
        Не найдена связь с аккаунтом социальной сети <strong><?=$socialProxy->getSocialTitle();?></strong>. Она будет добавлена после регистрации или <a href="<?=$this->createUrl('/oauth/main/auth');?>">авторизации</a> в RUNET-ID.
      </div>
    <?endif;?>

    <p><?=Yii::t('app', 'Вы&nbsp;можете одновременно получить RUNET-ID и&nbsp;зарегистрироваться на&nbsp;мероприятие, заполнив форму:');?></p>
    <div class="control-group <?=$model->hasErrors('LastName') ? 'error' : '';?>">
      <?=CHtml::activeTextField($model, 'LastName', array('class' => 'span4', 'placeholder' => $model->getAttributeLabel('LastName')));?>
    </div>
    <div class="control-group <?=$model->hasErrors('FirstName') ? 'error' : '';?>">
      <?=CHtml::activeTextField($model, 'FirstName', array('class' => 'span4', 'placeholder' => $model->getAttributeLabel('FirstName')));?>
    </div>
    <div class="control-group">
      <?=CHtml::activeTextField($model, 'FatherName', array('class' => 'span4', 'placeholder' => $model->getAttributeLabel('FatherName')));?>
    </div>
    <div class="control-group <?=$model->hasErrors('Email') ? 'error' : '';?>">
      <?=CHtml::activeTextField($model, 'Email', array('class' => 'span4', 'placeholder' => $model->getAttributeLabel('Email')));?>
    </div>
    <div class="control-group">
      <?=CHtml::activeTextField($model, 'Company', array('class' => 'span4', 'placeholder' => $model->getAttributeLabel('Company')));?>
    </div>
    <div class="control-group <?if ($model->Address->hasErrors()):?>error<?endif;?>">
      <?$this->widget('\contact\widgets\AddressControls', array('form' => $model->Address, 'address' => false, 'place' => false, 'inputClass' => 'input-block-level'));?>
    </div>

    <div class="control-group <?=$model->hasErrors('Phone') ? 'error' : '';?>">
      <?=CHtml::activeTextField($model, 'Phone', array('class' => 'span4', 'placeholder' => $model->getAttributeLabel('Phone')));?>
    </div>
    <?=CHtml::errorSummary($model, '<div class="alert alert-error">', '</div>');?>

    <p class="muted agreement">Нажимая кнопку «<?=Yii::t('app', 'Зарегистрироваться');?>», я принимаю условия <a target="_blank"
            href="<?=Yii::app()->createUrl('/page/info/agreement');?>">Пользовательского соглашения</a> и даю своё согласие RUNET-ID на обработку моих персональных данных, в соответствии с Федеральным законом от 27.07.2006 года №152-ФЗ «О персональных данных»</p>

    <button type="submit" class="btn btn-large btn-block btn-info"><i class="icon-ok-sign icon-white"></i>&nbsp;<?=Yii::t('app', 'Зарегистрироваться');?></button>
  </fieldset>
<?=CHtml::endForm();?>
<hr>
<p><?=\Yii::t('app', 'Если вы&nbsp;уже получали RUNET-ID&nbsp;&mdash; <a href="{url}">авторизуйтесь</a>.', array('{url}' => $this->createUrl('/oauth/main/auth')));?></p>
