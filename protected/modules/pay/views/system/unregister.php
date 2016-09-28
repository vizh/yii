<?php
/**
 * @var $error string
 * @var \pay\models\Account $account
 */
?>
<div class="container m-top_40 m-bottom_40">
  <div class="row">
    <div class="span8 offset2">
      <?if(!$account->SandBoxUser):?>
        <div class="well">
          <h4 class="m-bottom_10"><?=Yii::t('app', 'Вы не авторизованы в системе RUNET-ID.')?></h4>
          <p>
            <?=\Yii::t('app', 'Для полного доступа к платежному кабинету <a id="PromoLogin" href="">авторизуйтесь или зарегистрируйтесь.</a>')?>
          </p>

          <?=\CHtml::beginForm()?>
            <div class="control-group">
              <label for="pay_email"><?=Yii::t('app', 'Для создания временного аккаунта введите Email:')?></label>
              <div class="controls">
                <input id="pay_email" class="span4" name="email" value="" type="text">
                 <span class="help-block"><?=Yii::t('app', 'На указанный Email будет выслано письмо, с инструкциями по использованию временного аккаунта.')?></span>
              </div>
            </div>
            <button type="submit" class="btn btn-info"><?=Yii::t('app', 'Продолжить')?></button>
          <?=\CHtml::endForm()?>
        </div>
      <?else:?>
        <div class="well">
          <h4 class="m-bottom_10"><?=Yii::t('app', 'Экспресс-оплата')?></h4>
          <?=\CHtml::beginForm()?>
            <div class="control-group">
              <label for="pay_email">E-mail:</label>
              <div class="controls">
                <input id="pay_email" class="span4" name="email" value="" type="text">
                 <span class="help-block"><?=Yii::t('app', 'На ваш почтовый ящик придет письмо с информацией о платеже.')?></span>
              </div>
            </div>

            <?if(!empty($account->SandBoxUserRegisterUrl)):?>
              <p>
                <strong>
                  <?=Yii::t('app', 'Если вы еще не зарегистрировались на мероприятие или хотите зарегистрировать своих коллег, пройдите по ссылке <a target="_blank" href="{href}">зарегистрироваться</a>.', [5, '{href}' => $account->SandBoxUserRegisterUrl])?></strong>
              </p>
            <?endif?>

            <button type="submit" class="btn btn-info"><?=Yii::t('app', 'Продолжить')?></button>
          <?=\CHtml::endForm()?>
        </div>
      <?endif?>
    </div>
  </div>
</div>