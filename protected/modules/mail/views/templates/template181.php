<?php
/**
 * @var User $user
 */
use user\models\User;

$key = substr(md5($user->RunetId.'AFWf4BwXVXpMUblVQDICoUz0'), 0, 16);
$goldenSiteRegLink = "http://2014.goldensite.ru/personal/?RUNETID=" . $user->RunetId . "&KEY=" . $key;
?>
<h3>Здравствуйте, <?=$user->getShortName()?>.</h3>

<p>Вы получили это письмо, т.к. зарегистрировались на &quot;Золотом Сайте&quot; и имеете неоплаченные работы.</p>

<p>Этап приема работ подходит к концу и если вы хотите успеть принять участие в конкурсе, важно завершить процедуру оплаты. Перейдите к списку работ и выберите удобный для вас способ оплату.</p>

<p style="text-align: center;">
    <a href="<?=$goldenSiteRegLink?>" style="display: inline-block; background: #3B3B3B; color: #ffffff; padding: 10px 20px; border-radius: 4px; border-top: 1px solid #737373; border-left: 1px solid #737373; text-decoration: none;">Мои работы</a>
</p>

<p>В случае, если оплата будет осуществляться от юридического лица, не будет лишним если вы пришлете нам платежку с отметкой банка об исполнении.</p>

<p style="font-style: italic;">С уважением,<br />
Оргкомитет конкурса &quot;Золотой Сайт 2014&quot;</p>
