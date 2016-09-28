<div class="btn-toolbar">
    <?=\CHtml::link('&larr; Вернуться к редактору мероприятия', ['edit/index', 'eventId' => $event->Id], ['class' => 'btn'])?>
    <?=\CHtml::link('Создать письмо', ['edit', 'id' => $event->Id], ['class' => 'btn btn-success'])?>
</div>
<div class="well">
    <?if (!empty($mails)):?>
        <table class="table">
            <thead>
            <th><?=\Yii::t('app', 'Тема')?></th>
            <th><?=\Yii::t('app', 'Роли')?></th>
            <th><?=\Yii::t('app', 'Исключая роли')?></th>
            <th></th>
            </thead>
            <tbody>
            <?foreach($mails as $mail):?>
                <tr>
                    <td><?=$mail->Subject?></td>
                    <td>
                        <?if (!empty($mail->Roles)):?>
                            <?foreach($mail->getRoles() as $role):?>
                                <span class="label"><?=$role->Title?></span>
                            <?endforeach?>
                        <?else:?>
                            <span class="label"><?=\Yii::t('app', 'Все')?></span>
                        <?endif?>
                    </td>
                    <td>
                        <?if (!empty($mail->RolesExcept)):?>
                            <?foreach($mail->getRolesExcept() as $role):?>
                                <span class="label m-bottom_5"><?=$role->Title?></span>
                            <?endforeach?>
                        <?else:?>
                            <span class="label"><?=\Yii::t('app', 'Без исключений')?></span>
                        <?endif?>
                    </td>
                    <td>
                        <?=\CHtml::link('Редактировать', ['edit', 'id' => $event->Id, 'idMail' => $mail->Id], ['class' => 'btn'])?>
                </tr>
            <?endforeach?>
            </tbody>
        </table>
    <?else:?>
        <div class="alert alert-error"><?=\Yii::t('app', 'У мероприятия нет регистрационных писем!')?></div>
    <?endif?>
</div>