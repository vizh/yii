<?php	
	$regLink = "http://riw.moscow/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'vyeavbdanfivabfdeypwgruqe'), 0, 16);
?>

<p><img src="https://showtime.s3.amazonaws.com/201510201156-riw15-logo.jpg" style="height: auto; width: 100%" /></p>

<h3><?=$user->getShortName();?>, здравствуйте!</h3>

<p>Завтра&nbsp;&mdash; <strong>в&nbsp;среду 21&nbsp;октября в&nbsp;10:00 утра</strong>&nbsp;&mdash; в&nbsp;московском Экспоцентре откроется <strong>Выставка &laquo;ИНТЕРНЕТ 2015</strong>&raquo;.</p>

<p>Выставка проходит в&nbsp;рамках <a href="http://riw.moscow">Российской Интерактивной Недели</a> (Russian Interactive Week) с&nbsp;21&nbsp;по&nbsp;23&nbsp;октября.</p>

<p>Вы&nbsp;можете зарегистрироваться прямо сейчас в&nbsp;качестве <strong>посетителя Выставки &laquo;Интернет 2015&raquo; и&nbsp;участника Общей программы Форума RIW 2015</strong></p>

<div style="text-align: center; border: 3px dashed #F7264A; margin-top: 20px;">
	<p style="margin-top: 10px 0; text-align: center;"><a href="<?=$regLink?>" style="font-size: 100%; color: #fff; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #F7264A; margin: 0 10px 0 0; padding: 0; border-color: #F7264A; border-style: solid; border-width: 10px 40px;">БЕСПЛАТНАЯ РЕГИСТРАЦИЯ В ОДИН КЛИК</a></p>
</div>

<p>Зарегистрированным участникам Выставки &laquo;Интернет 2015&raquo; будут доступны все 3&nbsp;дня: посещение выставки, 3&nbsp;зала Общей программы RIW (и&nbsp;видео из&nbsp;этих залов), возможность быстрой регистрации в&nbsp;качестве Профессионального участника.</p>

<p>Подробная информация для участников доступна в&nbsp;разделе <a href="http://riw.moscow/info/guide/">&laquo;Гид участника&raquo;</a> на&nbsp;официальном сайте мероприятия.</p>

<p>До&nbsp;встречи на&nbsp;главном осеннем мероприятии Рунета!</p>
