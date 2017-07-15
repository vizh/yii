<?php

use api\components\Controller;
use nastradamus39\slate\annotations\ApiContent;
use nastradamus39\slate\annotations\ApiController;
use nastradamus39\slate\annotations\ApiError;
use nastradamus39\slate\annotations\ApiObject;

/**
 * @ApiController(
 *     controller="Company",
 *     title="Компании",
 *     description="Описаие методов для работы с компаниями"
 * )
 *  * @ApiContent(
 *     title="Разработчикам",
 *     description="
<b>POSTMAN</b><br/>
<p>Для удобства сделана коллекция для postman( GUI для выполнения HTTP запросов ). Можно скачать c оф.
<a target='blank' href='https://www.getpostman.com/'>сайта</a>.
Псле установки нужно:
- скачать и импортировать <a target='blank' href='runet-id.com.postman_collection.json'>коллекцию</a> запросов.
- загрузить и импортировать <a target='blank' href='api.runet-id.com.postman_environment.json'>окружение</a>
- ApiKey и Hash в окружении заменить на Ваши
</p>
<b>SDK</b><br/>
Для интеграции с API можно использовать готовый клиент. Описание методов так же можно найти на странице клиента.
- PHP SDK находится <a target='blank' href='https://bitbucket.org/ruvents/runet-id-php-api-client'>тут</a>
"
 * )
 * @ApiContent(
 *     title="Общая информация",
 *     description="
Запрос к методам API представляет собой обращение по HTTP-протоколу к URL вида http://api.runet-id.com/<название метода>.
Переменные методов передаются с помощью GET или POST параметров. В качестве результата возвращается JSON объект.
Для каждого мероприятия генерируются ApiKey и Secret. Доступ к API для каждого ApiKey ограничивается списком ip-адресов.
<strong>Обязательные для всех методов заголовки:</strong>
1. ApiKey
2. Hash - вычисляется по формуле md5(ApiKey+Secret)
<strong>Формат возвращаемых ошибок:</strong>
{
Error: {Code: int, Message: string}
}
<strong>Мультиаккаунты:</strong>
В некоторых случаях выдаётся аккаунт без конкретной привязки к мероприятию. В этом случае большинство методов
начинают требовать передачи дополнительного параметра: EventId, с идентификатором мероприятия в контексте которого
необходимо выполнить действие.
<strong>При использовании php-API:</strong>
$api = new \RunetID\Api\Api(ApiKey, Secret, Cache = null);
где Cache - объект класса, реализующего интерфейс \RunetID\Api\ICache"
 * )
 * @ApiObject(
 *     code="COMPANY",
 *     title="Компания",
 *     json="{
'Id':77529,
'Name':'RUVENTS',
'FullName':'ООО «РУВЕНТС»',
'Info':null,
'Logo': '{$LOGO}',
'Url':'http://ruvents.com',
'Phone':'+7 (495) 6385147',
'Email':'info@ruvents.com',
'Address':'г. Москва, Пресненская наб., д. 12',
'Cluster':'РАЭК',
'ClusterGroups':[],
'OGRN':null,
'Employments':['{$USER}']
}",
 *     description="Компания",
 *     params={
 *          "Id"            :"Идентификатор компании",
"Name"          :"Название",
"FullName"      :"Полное название",
"Info"          :"Информация о компании",
"Logo"          :"Массив ссылок на логотипы в трех разрешениях",
"Url"           :"Сылка на сайт компании",
"Phone"         :"Телефон",
"Email"         :"Email компании",
"Address"       :"Адрес компании",
"Cluster"       :"Кластер,к которому относится компания. Пока только РАЭК",
"ClusterGroups" :"Список груп кластеров",
"OGRN"          :"ОГРН компании",
"Employments"   :"Массив сотрудников компании"
 *     }
 * )
 * @ApiObject(
 *     code="LOGO",
 *     title="Лого компании",
 *     json="{
'Small':'Ссылка на лого компании (50px*50px)',
'Medium':'Ссылка на лого компании (90px*90px)',
'Large':'Ссылка на лого компании (200px*200px)'
}",
 *     description="Логотипы компании в трех разрешениях",
 *     params={
 *          "Small":"Логотип размерами 50px на 50px",
 *          "Medium":"Логотип размерами 90px на 90px",
 *          "Large":"Логотип размерами 200px на 200px"
 *     }
 * )
 * @ApiObject(
 *     code="PHOTO",
 *     title="Фото пользователя",
 *     json="{
'Small':'http://runet-id.com/files/photo/0/454_50.jpg?t=1475191745',
'Medium':'http://runet-id.com/files/photo/0/454_90.jpg?t=1475191306',
'Large':'http://runet-id.com/files/photo/0/454_200.jpg?t=1475191317'
}",
 *     description="Фото пользователя в трех разрешениях",
 *     params={
"Small":"Фото размерами 50px на 50px",
"Medium":"Фото размерами 90px на 90px",
"Large":"Фото размерами 200px на 200px"
}
 * )
 * @ApiError(code="400", description="Bad Request – Your request sucks.")
 * @ApiError(code="401", description="Unauthorized – Your API key is wrong.")
 * @ApiError(code="403", description="Forbidden.")
 * @ApiError(code="404", description="Not Found.")
 * @ApiError(code="405", description="Method Not Allowed.")
 * @ApiError(code="406", description="Not Acceptable.")
 * @ApiError(code="410", description="Gone.")
 * @ApiError(code="418", description="I’m a teapot.")
 * @ApiError(code="429", description="Too Many Requests.")
 * @ApiError(code="500", description="Internal Server Error.")
 * @ApiError(code="503", description="Service Unavailable.")
 */
class CompanyController extends Controller
{
}
