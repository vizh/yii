<?php
/**
 * @var \event\widgets\Competence $this
 */
?>

<div class="registration registration-error">
    <h3 class="text-error text-center">
        <?if(!isset($this->WidgetCompetenceNotAuthMessage)):?>
            <?=\Yii::t('app', 'Для регистрации на мероприятие, пожалуйста, <a href="#" id="PromoLogin">авторизуйтесь или зарегистрируйтесь</a> в системе RUNET-ID.')?>
        <?else:?>
            <?=$this->WidgetCompetenceNotAuthMessage?>
        <?endif?>
    </h3>
</div>