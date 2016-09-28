<table border="0" cellpadding="0" cellspacing="0" class="body-wrap" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; width: 100%; margin: 0; padding: 0 10px; border-collapse: separate;">
	<tbody>
		<tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">
			<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">&nbsp;</td>
			<td bgcolor="#FFFFFF" class="container" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; display: block !important; max-width: 720px !important; clear: both !important; margin: 0 auto; padding: 0;">
			<div class="column-wrap" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; max-width: 720px !important; margin: 0 auto; padding: 0 20px; border-color: #E72400; border-style: solid; border-width: 3px;">
			<p><img alt="" src="https://monosnap.com/file/3fSFm5opItKo1sHcZVOihWa9DRCOGr.png" /></p>

			<p><span style="line-height: 1.6em;">Здравствуйте,&nbsp;<?=$user->getFullName()?>!</span></p>

			<p>Вы успешно зарегистрированы&nbsp;на мероприятие&nbsp;<strong><?=$user->Participants[0]->Event->Title?></strong>.</p>

			<p><strong>Дата проведения: </strong>10 ноября 2015 года.</p>

			<p><strong>Место проведения: </strong><span style="line-height: 20.8px;">&laquo;</span><span style="line-height: 20.8px;">Radisson</span><span style="line-height: 20.8px;">&nbsp;</span><span style="line-height: 20.8px;">Royal</span><span style="line-height: 20.8px;">&nbsp;</span><span style="line-height: 20.8px;">Hotel</span><span style="line-height: 20.8px;">&nbsp;</span><span style="line-height: 20.8px;">Moscow</span><span style="line-height: 20.8px;">&raquo;,&nbsp;</span>г. Москва, Кутузовский проспект, д. 2/1, стр.1</p>

			<p>Для прохода на научно-деловую часть &nbsp;вам необходимо распечатать и взять с собой ваш личный электроный билет:&nbsp;</p>

			<div style="text-align: center; background: #F0F0F0; border: 2px dashed #FFF; padding: 20px 10px 10px;">
			<p style="margin-top: 0"><a href="<?=$user->Participants[0]->getTicketUrl()?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #ED2B1F; margin: 0 10px 0 0; padding: 0; border-color: #ED2B1F; border-style: solid; border-width: 10px 40px;">Электронный билет</a></p>

			<p style="text-align:center">Ваш билет уникален и не подлежит передаче третьим лицам.</p>
			</div>

			<p>&nbsp;</p>

			<p><strong style="line-height: 1.6em;"><span style="line-height: 20.8px;">До встречи на мероприятии!</span></strong></p>
			</div>
			</td>
			<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; margin: 0; padding: 0;">&nbsp;</td>
		</tr>
	</tbody>
</table>
<!-- /BODY --><!-- FOOTER -->