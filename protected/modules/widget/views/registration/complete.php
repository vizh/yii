<?php
/**
 * @var \widget\components\Controller $this
 * @var \event\models\Participant[] $participants
 */
?>
<h4 class="text-success"><?=\Yii::t('app', 'Пользователи успешно зарегистрированы на мероприятие {event}. Ниже вы можете посмотреть электронные билеты.', ['{event}' => $this->getEvent()->Title])?></h4>
<hr/>
<table class="table participants">
    <thead>
        <tr>
            <th colspan="3"><h4><?=\Yii::t('app', 'Зарегистрированные пользователи')?></h4></th>
        </tr>
    </thead>
    <tbody>
        <?foreach($participants as $participant):?>
            <tr>
                <td><?=$participant->User->getFullName()?></td>
                <td class="text-center col-width"><?=\CHtml::tag('span', ['class' => 'label label-success'], $participant->Role->Title)?></td>
                <td class="text-right"><?=\CHtml::link(\Yii::t('app', 'Электронный билет'), $participant->getTicketUrl(), ['target' => '_blank', 'class' => 'btn btn-default btn-sm'])?></td>
            </tr>
        <?endforeach?>
    </tbody>
</table>
<div class="text-center">
    <?=\CHtml::link(\Yii::t('app', 'Назад'), ['participants'], ['class' => 'btn btn-default btn-lg'])?>
</div>

