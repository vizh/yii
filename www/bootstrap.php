<?php
error_reporting(E_ALL | E_STRICT);
if (ini_get('display_errors') != 1) { // проверяет значение опции display_errors
	ini_set('display_errors', 1); // включает вывод ошибок вместе с результатом работы скрипта
};
date_default_timezone_set('Europe/Moscow');
setlocale(LC_TIME, 'ru.UTF-8');

/**
 * additional hosts
 */
Registry::AddHosts(array('m.beta.rocid', 'm.rocid.ru'), 'mobile', '');
Registry::AddHosts(array('api.beta.rocid', 'api.rocid.ru', 'zapi.beta.rocid'), 'api', '');
Registry::AddHosts(array('pay.beta.rocid', 'pay.rocid.ru'), 'pay', '');

Cookie::SetDomain('.'.ROCID_HOST);