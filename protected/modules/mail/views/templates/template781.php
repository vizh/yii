<?php
$coupon = new \pay\models\Coupon();
$coupon->EventId = 2319;
$coupon->Discount = 1000;
$coupon->ManagerName = 'Fix';
$coupon->Code = $coupon->generateCode();
$coupon->save();

$coupon->addProductLinks([
    \pay\models\Product::findOne(4018),
    \pay\models\Product::findOne(4017),
    \pay\models\Product::findOne(4016),
    \pay\models\Product::findOne(4015),
    \pay\models\Product::findOne(4013)
]);
?>


<p>Спасибо за ваше участие в прошлых конференциях&nbsp;DevCon, мы надеемся, что у вас остались только самые приятные
    воспоминания!</p>

<p><a href="http://www.msdevcon.ru/registration"
      target="_blank">Регистрация</a>&nbsp;на&nbsp;<strong>DevCon</strong><strong>&nbsp;2016</strong>&nbsp;уже открыта,
    и специально для вас, как для постоянного участника конференции, мы подготовили скидки! По вашим просьбам мы
    добавили&nbsp;<a href="http://www.msdevcon.ru/conditions" target="_blank">несколько разных категорий участия</a>,
    чтобы вы смогли выбрать максимально подходящий для вас вариант.</p>

<p>Используйте ваш персональный промокод, чтобы при&nbsp;<a href="http://www.msdevcon.ru/registration" target="_blank">регистрации</a>&nbsp;получить
    дополнительную скидку:</p>

<p><?=$coupon->Code?></p>

<p>Обращаем ваше внимание, что при оплате участия&nbsp;<strong>до 31 декабря</strong>&nbsp;<strong>действует сниженная
        цена!</strong>&nbsp;Более подробно с условиями участия вы можете ознакомиться на&nbsp;<a
        href="http://www.msdevcon.ru/conditions" target="_blank">сайте конференции</a>.</p>

<p>Крупнейшая конференция&nbsp;Microsoft&nbsp;для разработчиков&nbsp;<a href="http://www.msdevcon.ru/" target="_blank">DevCon&nbsp;2016</a>&nbsp;состоится&nbsp;<strong>25-26
        мая</strong>&nbsp;в традиционном загородном формате в одном из лучших подмосковных курортов. В этом годуDevCon&nbsp;пройдет<strong>
        &nbsp;в обновленном формате</strong>&nbsp;&ndash; больше экспертов, больше практики, больше знаний!</p>

<p><strong>Что вас ждет на&nbsp;</strong><strong>DevCon</strong><strong>&nbsp;2016?</strong></p>

<p><strong>3&nbsp;основные&nbsp;темы</strong>:</p>

<ul>
    <li>Windows 10 и Universal Windows Platform (UWP)</li>
    <li>&nbsp;Microsoft Office и&nbsp;повышение&nbsp;продуктивности</li>
    <li>Microsoft&nbsp;Azure&nbsp;и умные облачные технологии</li>
</ul>

<p><strong>4 ключевых доклада</strong>&nbsp;от экспертов из штаб-квартиры&nbsp;Microsoft</p>

<p><strong>5 треков докладов</strong>&nbsp;от экспертов&nbsp;Microsoft&nbsp;и индустрии</p>

<p><strong>Много практики</strong>&nbsp;и возможностей попробовать технологии своими руками:</p>

<ul>
    <li>Мастер-классы</li>
    <li>Ночной&nbsp;хакатон</li>
    <li>Выставка партнерских решений</li>
</ul>

<p><strong>Новый формат</strong><strong>:</strong>&nbsp;<a href="http://www.msdevcon.ru/intensive" target="_blank">интенсивы</a>&nbsp;с
    глубоким практическим погружением в технологии</p>

<p><strong>Общение с экспертами</strong></p>

<p><strong>Новое место проведения</strong>: 20 минут от Москвы, но все также среди сосен и белок</p>

<p><strong>Уникальная в</strong><strong>ечерняя</strong><strong>&nbsp;программа</strong>&nbsp;и сдача норм ГТО для
    разработчиков</p>

<hr/>
<p>По вопросам оплаты участия вы можете обращаться по адресу&nbsp;<a href="mailto:devcon@runet-id.com" target="_blank">devcon@runet-id.com</a>&nbsp;или
    телефону +7 (495) 950-56-51.</p>