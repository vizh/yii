<?php
/** @var \application\components\auth\WebUser $user */
$user = \Yii::app()->getUser();
?>
<script type="text/template" id="row-userdocumentalert-tpl">
    <tr class="alert-row">
        <td colspan="4">
            <div class="alert alert-error">
                <?=\Yii::t('app', 'В связи с повышенными мерами безопасности на данном мероприятие, требуется заполнение паспортных данных для проверки службой безопасности.')?>
                <% if (user.RunetId == '<?=!$user->getIsGuest() ? $user->getCurrentUser()->RunetId : null?>') { %>
                    <?=\Yii::t('app', 'Пожалуйста, пройдите в')?> <?=\CHtml::link(\Yii::t('app', 'настройки вашего профиля для их заполнения'), \Yii::app()->createUrl('/user/edit/document'), ['target' => '_blank'])?>.
                <% } else { %>
                    <?=\Yii::t('app', 'Для посещения мероприятия <%=user.FullName%> должен зайти в настройки своего профиля и заполнить их.')?>
                <% } %>
            </div>
        </td>
    </tr>
</script>