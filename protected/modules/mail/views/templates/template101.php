<p><img src="http://runet-id.com/img/mail/2014/header-bg-phd.jpg" alt=""/></p>

<?$user->setLocale('en')?>
<h2>Dear <?=$user->getFullName();?>!</h2>

<p>We invite you to participate in the international information security forum <a href="http://www.phdays.ru/" target="_blank">Positive Hack Days</a>. The&nbsp;<span style="line-height: 1.6em;">forum is expected to gather more than 2,000 participants and will be held at the Digital October Center </span><span style="line-height: 1.6em;">on May 21 and 22 this year.</span></p>

<p><a href="http://www.phdays.com/program/#2" target="_blank"><strong>The program of PHDays IV</strong></a> is ready and willing to entertain you nonstop. It includes: more than 100&nbsp;<span style="line-height: 1.6em;">reports, workshops, seminars and discussions; contests of the world&#39;s strongest teams of specialists in&nbsp;</span><span style="line-height: 1.6em;">information security, a competition of research papers of students, postgraduates and young scientists,&nbsp;</span><span style="line-height: 1.6em;">and a musical performance for the evening.</span></p>

<p>You can plan your activities at the forum beforehand. Please see the information for PHDays participants </p>

<p><a href="<?=$user->Participants[0]->getTicketUrl();?>" style="display: block; text-decoration: none; background: #e41937; color: #FFFFFF; font-family: Arial,Verdana,sans-serif; font-size: 20px; margin: 0 auto; padding: 12px; text-align: center; width: 300px;">E-TICKET</a></p>

<p>Questions? Please contact us <a href="http://www.phdays.com/contacts/" target="_blank">by phone or email</a>.</p>

<p>See you at PHDays!</p>

<p>&nbsp;</p>

<?$user->setLocale('ru')?>
<h2>Здравствуйте, <?=$user->getFullName();?>!</h2>

<p>Приглашаем Вас принять участие в работе четвертого Международного форума по практической безопасности <a href="http://www.phdays.ru/" target="_blank">Positive Hack Days</a>, который соберет более 2000 участников (21 и 22 мая 2014 года, Москва, техноцентр Digital October).</p>

<p><a href="http://www.phdays.ru/program/schedule/" target="_blank"><strong>Программа форума PHDays IV</strong></a> полностью сформирована и будет радовать Вас в режиме нон-стоп! В ней почти 100 докладов, семинаров, мастер-классов, отраслевых дискуссий; соревнования сильнейших команд мира по защите информации; конкурс исследовательских работ студентов, аспирантов и молодых ученых; вечерняя культурная программа.</p>

<p>Планируйте свое участие в мероприятиях форума заранее. Ознакомьтесь, пожалуйста, с информацией для участников PHDays.</p>

<p><a href="<?=$user->Participants[0]->getTicketUrl();?>" style="display: block; text-decoration: none; background: #e41937; color: #FFFFFF; font-family: Arial,Verdana,sans-serif; font-size: 20px; margin: 0 auto; padding: 12px; text-align: center; width: 300px;">ЭЛЕКТРОННЫЙ БИЛЕТ</a></p>

<p>Вопросы? Задайте их <a href="http://www.phdays.ru/contacts/" target="_blank">по телефону или электронной почте</a>.</p>

<p>До встречи на PHDays!</p>

<p>&nbsp;</p>