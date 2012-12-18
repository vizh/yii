<?php

/**
* Заголовки страниц
*/
$Words['titles']['plain'] = 'rocID://';
$Words['titles']['general'] = $Words['titles']['plain'] . ' - Информационный портал профессионалов Рунета';
$Words['titles']['about'] = $Words['titles']['plain'] . ' - О проекте';
$Words['titles']['ad'] = $Words['titles']['plain'] . ' - Реклама';

$Words['titles']['user_list'] = $Words['titles']['plain'] . ' - Список пользователей';
$Words['titles']['company_list'] = $Words['titles']['plain'] . ' - Список компаний';
$Words['titles']['company_rss'] = $Words['titles']['plain'] . ' RSS компании %s';
$Words['titles']['news'] = $Words['titles']['plain'] . ' Новости';
$Words['titles']['event'] = $Words['titles']['plain'] . ' Мероприятия';
$Words['titles']['eventusers'] = $Words['titles']['plain'] . ' Список участников';
$Words['titles']['video'] = $Words['titles']['plain'] . ' Видео';
$Words['titles']['search'] = $Words['titles']['plain'] . ' Поиск';
$Words['titles']['useredit'] = $Words['titles']['plain'] . ' Изменение профиля';
$Words['titles']['lunch'] = $Words['titles']['plain'] . ' Бизнес-ланч';

$Words['titles']['pay'] = $Words['titles']['plain'] . ' Оплата';


$Words['titles']['mobile'] = 'rocID - мобильная версия';

$Words['titles']['rss_companies'] = ' / Новости компаний';


/**
* Склонения месяцев
*/
$Words['calendar']['months'][1] = array('- Месяц -', 'январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь');
$Words['calendar']['months'][2] = array('- Месяц -', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');
$Words['calendar']['months'][3] = array('- Месяц -', 'январе', 'феврале', 'марте', 'апреле', 'мае', 'июне', 'июле', 'августе', 'сентябре', 'октябре', 'ноябре', 'декабре');

$Words['calendar']['daynames'] = array('воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота');

/**
* Константы для вывода адреса дом-строение-корпус
*/
$Words['address']['house'] = array(0 => 'д.', 1 => 'стр.', 2 => 'к.');

$Words['address']['option_country'] = 'Выберите страну';
$Words['address']['option_region'] = 'Выберите регион';
$Words['address']['option_city'] = 'Выберите город';

/**
* Константы для профиля. Активность пользователя.
*/
$Words['activity'][1] = 'Проект';
$Words['activity'][2] = 'Публикация';
$Words['activity'][3] = '«След»';


$Words['phones']['mobile'] = 'мобильный';
$Words['phones']['home'] = 'домашний';
$Words['phones']['work'] = 'рабочий';
$Words['phones']['secretary'] = 'секретарь';
$Words['phones']['fax'] = 'факс';


/**
* Списки пользователей/компаний
*/
$Words['list']['firstsearch'] = 'Найти';
$Words['list']['othersearch'] = 'Найти в другом месте';


/**
 * Редактирование пользователя
 */
$Words['edituser']['companytext'] = 'Укажите название компании';
$Words['edituser']['positiontext'] = 'Укажите свою должность';
$Words['edituser']['yeartext'] = 'год';

$Words['edituser']['emailtext'] = 'укажите действующий email';
$Words['edituser']['sitetext'] = 'укажите адрес сайта';

$Words['edituser']['emailnew'] = 'укажите новый email';

/**
 * Редактирование компании
 */
$Words['editcompany']['companytext'] = 'Укажите название компании';

$Words['editcompany']['emailtext'] = 'укажите действующий email';
$Words['editcompany']['sitetext'] = 'укажите адрес сайта';

$Words['editcompany']['emailnew'] = 'укажите новый email';


/**
 * Статусы
 */

$Words['status']['draft'] = 'Черновик';
$Words['status']['publish'] = 'Опубликовано';
$Words['status']['moderate'] = 'Премодерация';
$Words['status']['deleted'] = 'Удалено';
$Words['status']['hide'] = 'Скрыто';


/**
 * Новости
 */


$Words['news']['emptytitle'] = '(Без названия)';
$Words['news']['entertitle'] = 'Введите заголовок';

$Words['news']['emptycategory'] = '(Без категории)';

$Words['news']['cover']['first'] = 'У людей всегда найдется какая-нибудь статистика';
$Words['news']['cover']['second'] = 'Об этом известно 14% населения';


/**
 * Рассылка писем
 */

$Words['mail']['regsubject'] = 'rocID:// Регистрация';
$Words['mail']['jobrequest'] = 'Отзыв на вакансию: ';
$Words['mail']['vacancysend'] = 'Отправка вакансии: ';
$Words['mail']['eventsend'] = 'Отправка мероприятия: ';
$Words['mail']['recovery'] = 'Восстановление забытого пароля';


/**
 * Работа
 */
$Words['schedule']['full'] = 'Полный рабочий день';
$Words['schedule']['shift'] = 'Сменный';
$Words['schedule']['free'] = 'Свободный';
$Words['schedule']['parttime'] = 'Частичная занятость';
$Words['schedule']['remote'] = 'Удаленная работа';

/**
 * Тесты
 */
$Words['RetestTime']['1hour'] = '1 час';
$Words['RetestTime']['2hour'] = '2 часа';
$Words['RetestTime']['4hour'] = '4 часа';
$Words['RetestTime']['12hour'] = '12 часов';
$Words['RetestTime']['1day'] = '1 день';
$Words['RetestTime']['7day'] = '7 дней';
$Words['RetestTime']['month'] = '1 месяц';
$Words['RetestTime']['3month'] = '3 месяца';
$Words['RetestTime']['halfyear'] = 'пол года';

/**
 * Настройки
 */

$Words['type']['system'] = 'Системная';
$Words['type']['personal'] = 'Пользовательская';

/**
 * Ошибки
 */

$Words['error']['notsave'] = 'Ошибка сохранения!';
$Words['error']['required'] = 'Обязательные поля не заданы!';
$Words['error']['fio'] = 'Фамилия и имя не могут быть пустыми!';
$Words['error']['required-email'] = 'Обязательное поле email не задано!';
$Words['error']['wrong-email'] = 'Не верный формат email!';
$Words['error']['wrong-password'] = 'Текущий пароль введен не верно!';
$Words['error']['wrong-password-short'] = 'Введенный пароль должен быть длиннее 6 символов!';
$Words['error']['wrong-password-r'] = 'Пароли не совпадают!';

$Words['error']['wrong-email-current'] = 'Текущий email введен не верно!';
$Words['error']['wrong-email-r'] = 'Новый email и подтверждение не совпадают!';

Registry::SetWords($Words);

class Consts
{
	public static $rusChars = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ж', 'З', 'И', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Э', 'Ю', 'Я');
	public static $latChars = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
	
}