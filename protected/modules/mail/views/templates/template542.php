<?php
/**
 *  @var \user\models\User $user
 */
?>
<h3>Здравствуйте, <?=$user->getFullName()?>!</h3>

<p>Портал RUNET&mdash;ID, РАЭК, НИУ Высшая школа экономики, при поддержке Superjob и&nbsp;Министерства связи и&nbsp;массовых коммуникаций&nbsp;РФ начинают работу над <strong>рейтингом российских ВУЗов с&nbsp;точки зрения самой интернет-индустрии</strong>.</p>

<p>На&nbsp;первом этапе исследования нам необходимо отобрать <strong>100 ведущих вузов, выпускники которых наиболее представлены в&nbsp;сообществе</strong>. Для этого нам нужна ваша помощь: пожалуйста, пройдите про ссылке и&nbsp;ответьте на&nbsp;два вопроса!</p>

<p style="text-align: center;">
    <a href="<?=$user->getFastauthUrl('/vote/edu/')?>" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 2; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; background: #D23000; margin: 0 10px 0 0; padding: 0; border-color: #d23000; border-style: solid; border-width: 10px 40px;">ПЕРЕЙТИ К&nbsp;ОПРОСУ</a>
</p>

<p>Первые результаты и&nbsp;более подробная информация о&nbsp;дальнейших этапах составления рейтинга будет представлена 9&nbsp;июня на&nbsp;форуме РИФ.Иннополис.</p>

<p>Спасибо за&nbsp;участие в&nbsp;исследовании!</p>
