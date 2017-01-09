<?php
/**
 * @var \event\widgets\FastRegistration $this
 * @var \event\models\Role $role
 * @var \event\models\Event $event
 */
?>
<div class="event-registration registration fast">
    <h3 class="title"><?=Yii::t('app', 'Планирую посетить / Виртуальная регистрация')?></h3>
    <p><?=Yii::t('app', 'Если данное мероприятие Вам интересно, но на данный момент не готовы зарегистрироваться как участник, Вы можете добавить его в потенциально интересные.')?></p>
    <p><?=Yii::t('app', 'Мы будем информировать Вас о подготовке мероприятия, формировании программы, предупреждать о плановых повышениях стоимости участия (если таковые предполагаются), информировать о возможных скидках и акциях.')?></p>
    <br><br>
    <?=CHtml::form('', 'POST')?>
    <?=CHtml::hiddenField(Yii::app()->getRequest()->csrfTokenName, Yii::app()->getRequest()->getCsrfToken())?>
    <?if($user->getIsGuest()):?>
        <a href="#" class="btn btn-info" id="PromoLogin">
            <?=Yii::t('app', 'Авторизоваться / Зарегистрироваться')?>
        </a>
    <?else:?>
        <?=CHtml::submitButton(Yii::t('app', 'Планирую посетить'), [
            'class' => 'btn btn-info'
        ])?>
    <?endif?>
    <?=CHtml::endForm()?>
</div>
