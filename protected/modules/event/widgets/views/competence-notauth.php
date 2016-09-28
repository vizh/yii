<?php
/**
 * @var \event\widgets\Competence $this
 */
?>
<div class="alert alert-error">
  <p class="text-error lead m-top_10 m-bottom_10">
    <?if(!isset($this->WidgetCompetenceNotAuthMessage)):?>
      <?=\Yii::t('app', 'Для запроса или активации приглашения, пожалуйста, <a href="#" id="PromoLogin">авторизуйтесь или зарегистрируйтесь</a> в системе RUNET-ID.')?>
    <?else:?>
      <?=$this->WidgetCompetenceNotAuthMessage?>
    <?endif?>
  </p>
</div>