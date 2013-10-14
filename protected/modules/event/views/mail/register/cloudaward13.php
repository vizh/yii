<?
/*
 * @var user\models\User $user
 * @var event\models\Participant $participant
 */
?>


Здравствуйте, <?=$user->getShortName();?>!<br/><br/>

Благодарим Вас, за регистрацию на торжественную церемонию вручения ежегодной премии SAAS-решений «Облака 2013».<br/><br/>

<strong>Ваш личный пригласительный билет: <?=$participant->getTicketUrl();?></strong><br/><br/>

<strong>Ждем Вас 18 октября в 18.30, в конференц-центре гостиницы Novotel Moscow City. По адресу: Пресненская набережная д.2,  г. Москва</strong><br/><br/>

С Уважением,<br/>
Организационный комитет премии «Облака 2013»