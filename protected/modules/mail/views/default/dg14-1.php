Здравствуйте, <?=$user->getShortName()?>.

Знаете ли вы, что такое Digital Goods?
Digital Goods легко вычисляется по формуле:
________________________________

DG = buy online & consume online
________________________________

4 марта 2014 года РАЭК и PayPal при участии банка ВТБ24 проводят конференцию об электронной коммерции настоящего и будущего потребления цифровых товаров в интернете.

В программе конференции:
- Способы монетизации цифрового контента;
- Кейсы: лучшие российские и международные практики реализации цифрового контента;
- Круглый стол: Как стимулировать пользователя платить за контент?
- Мобильная коммерция;
- Практические кейсы и рекомендации по работе с мобильными пользователями от лидеров рынка;
- Безопасность и регулирование e-commerce технологий;
- Мастер-класс: Подключение магазина к платежной системе и повышение чек-аута;
- Маркетинг игр и контентных приложений;
- Рекомендательные и социальные модели распространения;
- Нативная реклама и контентные спецпроекты.

ОЗНАКОМИТЬСЯ С ПРОГРАММОЙ:
http://dgconf.com/program/

<?
$role = \event\models\Role::model()->findByPk(24);
$event = \event\models\Event::model()->findByPk(866);
$registerLink = $event->getFastRegisterUrl($user, $role, '/event/dg14/');
?>

ПРОЙТИ РЕГИСТРАЦИЮ:
<?=$registerLink?>


В программе Digital Goods 2014 примут участие российские и западные спикеры, эксперты цифровых товаров, представители российских интернет-магазинов и сервисов электронной коммерции, платежных систем и их клиентов.

Вам также есть о чем рассказать участникам?
Ваша компания планирует принять участие в выставке со стендом?
Ждем заявок на почту users@runet-id.com

Организаторы: РАЭК и PayPal. Генеральный партнер – банк ВТБ24
Место проведения конференции Digital Goods – конечно же Digital October.

Для всех продавцов цифрового контента до 30.06.2014 действует специальное предложение от PayPal. Подключите систему оплаты PayPal на Вашем сайте на льготных условиях.

До встречи на конференции Digital Goods 2014!


--
С уважением,
http://runet-id.com

Отписаться: <?=$user->getFastauthUrl('/user/setting/subscription/')?>