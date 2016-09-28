<?php
/**
 * @var Invite $this
 */

use event\widgets\Invite;

$formActivation = $this->formActivation;
$formRequest = $this->formRequest;

?>

<div class="registration widget-invite" id="<?=$this->getNameId()?>">
    <h5 class="title">
        <?if (isset($this->WidgetInviteTitle) && !empty($this->WidgetInviteTitle)):?>
            <?=$this->WidgetInviteTitle?>
        <?else:?>
            <?=Yii::t('app', 'Регистрация по приглашениям')?>
        <?endif?>
    </h5>
    <?if (isset($this->WidgetInviteDescription) && !empty($this->WidgetInviteDescription)):?>
        <?=$this->WidgetInviteDescription?>
    <?else:?>
        <p>Регистрация на конференцию осуществляется по приглашениям от организаторов мероприятия. Если у вас есть
            приглашение (промо-код), введите его для прохождения регистрации.</p>
        <p>Если у вас нет приглашения, но вы желаете посетить мероприятие, отправьте запрос на участие
            организаторам.</p>
    <?endif?>

    <?$this->widget('\event\widgets\Participant', [
        'widget' => $this
    ])?>

    <?if (!\Yii::app()->getUser()->getIsGuest()):?>
        <?if (\Yii::app()->getUser()->hasFlash('widget.invite.success')):?>
            <div class="alert alert-success"><?=\Yii::app()->getUser()->getFlash('widget.invite.success')?></div>
        <?endif?>
        <div>
            <?if (!isset($this->WidgetInviteHideCodeInput) || $this->WidgetInviteHideCodeInput == 0):?>
                <h5><?=Yii::t('app', 'Регистрация')?></h5>
                <?=\CHtml::errorSummary($formActivation, '<div class="alert alert-error">', '</div>')?>
                <?=\CHtml::beginForm('', 'POST', ['class' => 'form-inline'])?>
                <?=\CHtml::activeTextField($formActivation, 'FullName', ['class' => 'input-large', 'placeholder' => $formActivation->getAttributeLabel('FullName')])?>
                <?=\CHtml::activeTextField($formActivation, 'Code', ['class' => 'input-medium', 'placeholder' => $formActivation->getAttributeLabel('Code')])?>
                <?=\CHtml::activeHiddenField($formActivation, 'RunetId')?>
                <?=\CHtml::hiddenField('Form', get_class($formActivation))?>
                <?=\CHtml::submitButton(\Yii::t('app', 'Активировать'), ['class' => 'btn'])?>
                <p class="help-block m-top_5">Начинайте вводить на клавиатуре имя владельца приглашения, чтобы выбрать
                    его из списка.</p>
                <?=\CHtml::endForm()?>
            <?endif?>

            <h5><?=\Yii::t('app', 'Получить приглашение')?></h5>
            <?=\CHtml::errorSummary($formRequest, '<div class="alert alert-error">', '</div>')?>
            <?=\CHtml::beginForm('', 'POST')?>
            <div class="form-inline">
                <?=\CHtml::activeTextField($formRequest, 'FullName', ['class' => 'input-large', 'placeholder' => $formRequest->getAttributeLabel('FullName')])?>
                <?=\CHtml::activeHiddenField($formRequest, 'RunetId')?>
                <?=\CHtml::hiddenField('Form', get_class($formRequest))?>
                <?=\CHtml::submitButton(\Yii::t('app', 'Отправить'), ['class' => 'btn'])?>
                <p class="help-block m-top_5">Начинайте вводить на клавиатуре имя владельца приглашения, чтобы выбрать
                    его из списка.</p>
            </div>
            <?=\CHtml::endForm()?>
        </div>
    <?else:?>
        <p class="text-error">
            <?if (!isset($this->WidgetInviteHideCodeInput) || $this->WidgetInviteHideCodeInput == 0):?>
                <?=\Yii::t('app', 'Для запроса или активации приглашения, пожалуйста, <a href="#" id="PromoLogin">авторизуйтесь или зарегистрируйтесь</a> в системе RUNET-ID.')?>
            <?else:?>
                <?=\Yii::t('app', 'Для запроса приглашения, пожалуйста, <a href="#" id="PromoLogin">авторизуйтесь или зарегистрируйтесь</a> в системе RUNET-ID.')?>
            <?endif?>
        </p>
    <?endif?>
</div>