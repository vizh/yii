<?php
/**
 * @var user\models\User $user
 */

use event\models\UserData;

/** @var UserData $data */
$data = UserData::model()->byEventId(2319)->byUserId($user->Id)->byDeleted(false)->orderBy('CreationTime DESC')->find();
if ($data) {
	$manager = $data->getManager();
}
?>
<p>Здравствуйте, <?=$user->getShortName()?>&nbsp;!<br />
Спешим напомнить, что вы зарегистрированы на сертификационный экзамен в рамках DevCon 2016.&nbsp;</p>

<?php if (isset($manager)): ?>
	<b>
		<?=$manager->CertificationDate?>
		<?=$manager->CertificationTime?>,
		<?=$manager->CertificationExamId?>,
		><?=$manager->CertificationExamTitle?>
	</b>
<?php endif ?>

<p>Если ваши планы поменялись, и вы не сможете прийти на экзамен, пожалуйста, срочно сообщите нам: v-devcon@microsoft.com; +7 (926) 37-37-320.&nbsp;<br />
Ознакомьтесь, пожалуйста, с важной организационной информацией:</p>

<ol>
	<li>Для вас зарезервирован временной слот для сдачи экзамена. Количество и время слотов строго зафиксировано, вы не можете прийти на сдачу экзамена на другой слот или перенести его.</li>
	<li>Среднее время сдачи экзаменов &ndash; 2,5 часа, размер зарезервированного слота &ndash; 3 часа. Мы просим вас подойти к Центру Сертификации за 5 минут до начала вашего слота.</li>
	<li>ВНИМАНИЕ: При опоздании на экзамен более, чем на 15 минут, ваш слот сгорает, вы не сможете сдать экзамен ни в какое другое время!</li>
	<li>Если вы не сможете прийти в Центр Сертификации в течение 15 минут после начала слота, ваш ваучер будет передан участнику конференции из листа ожидания.&nbsp;</li>
</ol>

<p>Место расположения Центра Сертификации (обозначен цифрой 8 и жёлтым цветом):</p>

<p><img alt="" src="https://monosnap.com/file/zoLbXoR1nQ4h60zYMXZgaYvPT1eXIr.png" /></p>
