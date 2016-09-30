<?php
/**
 * @var \user\models\User $user
 * @var string $password
 */
?>
<h2><?=$user->getFullName()?>,</h2>
<p>Вы создали аккаунт в RUNET—ID, единой системе регистрации на ИТ-мероприятия Рунета.</p>
<p style="margin-bottom: 20px;">Это не социальная сеть. Это сервис, позволяющий быстро и удобно регистрироваться на большую часть проводимых в России форумов, конференций, семинаров, вебинаров и тренингов связанных с интернет, телеком и медиа.</p>

<table style="width: 100%;">
    <tr>
        <td style="width: 50%; vertical-align: top; border: 3px dashed #EDEDED; border-right: 0; padding: 20px;">
            <h2 style="padding: 0; margin: 0 0 20px;">Подтвердите аккаунт</h2>
            <p style="padding: 0; margin: 0;">Для того, что бы мы могли отправлять Вам электронные билеты, новости по мероприятиям на которые вы будете регистрироваться и информировать об уникальных событиях, просим подтвердить свой аккаунт.</p>
            <div style="text-align: center; margin: 20px 0 0;">
                <?=\CHtml::link('ПОДТВЕРДИТЬ АККАУНТ', $user->getVerifyUrl(), ['style' => 'font-size: 14px; line-height: 2; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: block; background: #2F8EDC; margin: 0; padding: 0; border-color: #2f8edc; border-style: solid; border-width: 10px 40px;'])?>
            </div>
        </td>
        <td style="width: 50%; vertical-align: top; background-color: #EDEDED; border: 3px solid #EDEDED; padding: 20px;">
            <h2 style="padding: 0; margin: 0 0 20px;">Ваши данные</h2>
            <div style="margin-bottom: 5px;"><strong>RUNET-ID</strong>: <?=$user->RunetId?></div>
            <div style="margin-bottom: 5px;"><strong>Пароль: <span style="text-decoration: underline;"><?=$password?></span></strong></div>
            <div style="margin-bottom: 5px;"><strong>Email</strong>: <?=$user->Email?></div>
        </td>
    </tr>
</table>

<h2>Быть в курсе</h2>
<p><strong>RUNET-ID</strong> включает наиболее полный <a href="http://runet-id.com/events/">каталог ИТ-мероприятий</a>, а зарегистрированные пользователи нашего сервиса получают возможность упрощенной регистрации на многие из этих мероприятий, оперативно получают информацию о специальных предложениях, акциях и бонусах.</p>
<p>Пользователям, ежегодно участвующим в мероприятиях, <strong>RUNET-ID</strong> периодически дарит скидки.</p>

<h2>Организуете конференции?</h2>
<p><strong>RUNET-ID</strong> - сервис для компаний. Если вы организуете конференции, семинары, вебинары, форумы, премии или иные мероприятия медиа- и интернет-направленности, сервис позволяет открыть мероприятие и сообщить об этом целевой аудитории.</p>
<p>Для привлечения аудитории мы предлагаем как внутренние ресурсы системы, так и задействуем внешние источники (контекстная реклама, работа с пользователями социальных сетей, реклама в средствах массовой информации, рекламно-информационная продукция).</p>

<h2>Поддержка</h2>
<p style="margin-bottom: 80px;">По всем вопросам работы сервиса вы всегда можете обратиться в нашу службу поддержки пользователей:<br/><a href="mailto:support@runet-id.com">support@runet-id.com</a></p>

<p>С уважением,<br/>команда поддержки RUNET-ID</p>