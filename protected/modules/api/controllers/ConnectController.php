<?php

use nastradamus39\slate\annotations\ApiController;
use nastradamus39\slate\annotations\ApiObject;

/**
 * @ApiController(
 *     controller="Connect",
 *     title="Встречи",
 *     description="Методы для работы со встречами."
 * )
 * @ApiObject(
 *     code="PLACE",
 *     title="Место",
 *     json="{'Id': 4, 'Name': 'Meeting point 1', 'Reservation': 'true', 'ReservationTime': 20}",
 *     description="Место встречи.",
 *     params={"Id":"Айди места встречи", "Name":"Название", "Reservation":"Возможность бронирования"}
 * ),
 * @ApiObject(
 *     code="MEETING",
 *     title="Встреча",
 *     json="{
'Id': 2817,
'Place': '{$PLACE}',
'Creator': '{$USER}',
'Users': [
{'Status': 1,'Response': '', 'User': '{$USER}'}
],
'UserCount': 1,
'Start': '2009-02-15 00:00:00',
'Date': '2009-02-15',
'Time': '00:00',
'Type': 1,
'Purpose': '',
'Subject': '',
'File': '',
'CreateTime': '2017-02-12 23:12:34',
'Status': 2,
'CancelResponse': ''
}",
 *     description="Встреча.",
 *     params={
 *          "Id"        : "Идентификатор встречи",
 *          "Place"     : "Место встречи",
 *          "Creator"   : "Создатель встречи",
 *          "Users"     : "Пользователи, приглашенные на встречу",
 *          "UserCount" : "Колличество пользователей приглашенных на встречу",
 *          "Start"     : "Время начала встречи",
 *          "Date"      : "Дата встречи",
 *          "Time"      : "Время встречи",
 *          "Type"      : "Тип встречи. 1-закрытая,2-открытая",
 *          "Purpose"   : "Цель встречи",
 *          "Subject"   : "Тема встречи",
 *          "File"      : "Прилагаемые материалы. Файл.",
 *          "CreateTime": "Дата создания",
 *          "Status"    : "Статус. 1-открыта,2-отменена."
 *     }
 * )
 */
class ConnectController extends \api\components\Controller
{

}
