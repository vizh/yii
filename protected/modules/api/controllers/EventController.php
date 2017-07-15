<?php

use api\components\Controller;
use nastradamus39\slate\annotations\ApiController;
use nastradamus39\slate\annotations\ApiObject;

/**
 * @ApiController(
 *     controller="Event",
 *     title="Мероприятия",
 *     description="Методы для работы с мероприятиями. Аккаунт API соответствует конкретному мероприятию. Методы описанные в данном разделе работают с мероприятием аккаунта. Но можно получить список мероприятий в методе list."
 * )
 * @ApiObject(
 *     code="HALL",
 *     title="Зал",
 *     json="{'Id': '599','Title': 'Зал 1','UpdateTime': '2017-02-19 12:29:58','Order': '0', 'Deleted': false }",
 *     description="Зал, где может проходить часть или все мероприятие. Залы привязываются к секциям.",
 *     params={
 *          "Id":"Идентификатор",
 *          "Title":"Название зала",
 *          "UpdateTime":"Время последнего обновления зала в формате (Y-m-d H:i:s)",
 *          "Order":"Порядок вывода залов",
 *          "Deleted" : "true - если зал удален, false - иначе"
 *     }
 * )
 * @ApiObject(
 *     code="EVENT",
 *     title="Мероприятие",
 *     json="{
'EventId': 3206,
'IdName': 'Meropriyatiegoda',
'Name': 'Мероприятие 2017 года',
'Title': 'Мероприятие 2017 года',
'Info': 'Краткое описание мероприятия 2017',
'Place': 'г. Волгоград, пр-т Ленина, д. 123',
'Url': 'http://www.runet-id.com',
'UrlRegistration': '',
'UrlProgram': '',
'StartYear': 2017,
'StartMonth': 2,
'StartDay': 22,
'EndYear': 2017,
'EndMonth': 2,
'EndDay': 22,
'Image': {
'Mini': 'http://runet-id.dev/files/event/Meropriyatiegoda/50.png',
'MiniSize': { 'Width': 50, 'Height': 50 },
'Normal': 'http://runet-id.dev/files/event/Meropriyatiegoda/120.png',
'NormalSize': { 'Width': 120, 'Height': 120 }
},
'GeoPoint': [ '', '' ],
'Address': 'г. Волгоград, пр-т Ленина, д. 123',
'Menu': [{'Type': 'program', 'Title': 'Программа' }],
'Statistics': {
'Participants': { 'ByRole': {'24': 1 }, 'TotalCount': 1 }
},
'FullInfo': '<p>Подробное описание мероприятия 2017</p>\r\n'
}",
 *     description="Информация о мероприятии.",
 *     params={
 *          "EventId" : "Идентификатор мероприятия",
 *          "IdName" : "Символьный код мероприятия",
 *          "Name" : "Название мероприятия",
 *          "Title" : "Название мероприятия",
 *          "Info" : "Информация о мероприятии",
 *          "Place" : "Место проведения мероприятия",
 *          "Url" : "Сайт мероприятия",
 *          "UrlRegistration" : "",
 *          "UrlProgram" : "",
 *          "StartYear" : "Год начала мероприятия",
 *          "StartMonth" : "Месяц начала мероприятия",
 *          "StartDay" : "День начала мероприятия",
 *          "EndYear" : "Год окончания мероприятия",
 *          "EndMonth" : "Месяц окончания мероприятия",
 *          "EndDay" : "День окончания мероприятия",
 *          "Image" : "Ссылки на логотип мероприятия в двух разрешениях",
 *          "GeoPoint" : "Координаты места проведеня мероприятия",
 *          "Address":"Адрес места проведения мероприятия",
 *          "Menu" : "",
 *          "Statistics" : "Статистика мероприятия по участникам/ролям",
 *          "FullInfo" : "Подробное описание мероприятия"
 *     }
 * )
 * @ApiObject(
 *     code="EVENTROLE",
 *     title="Статус на мероприятии",
 *     json="{'RoleId': 'идентификатор статуса на мероприятии','RoleTitle': 'название статуса','UpdateTime': 'время последнего обновления'}",
 *     description="Статус на мероприятии.",
 *     params={
 *          "RoleId" : "Идентификатор роли участника мероприятия.",
 *          "RoleTitle" : "Название роли",
 *          "UpdateTime" : "Время последнего обновления"
 *     }
 * )
 */
class EventController extends Controller
{
}
