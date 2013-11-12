<?php
/**
 * @var \event\widgets\Competence $this
 */
?>
<div class="alert alert-error">
  <p class="text-error">
    <?if (!isset($this->WidgetCompetenceErrorKeyMessage)):?>
      <?=\Yii::t('app', 'Для запроса или активации приглашения, пожалуйста, <a href="#" id="PromoLogin">авторизуйтесь или зарегистрируйтесь</a> в системе RUNET-ID.');?>
    <?else:?>
      <?=$this->WidgetCompetenceErrorKeyMessage;?>
    <?endif;?>
  </p>
</div>