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
            'Place': 'Объект PLACE',
            'Creator': 'Объект USER',
            'Users': [
                {'Status': 1,'Response': '', 'User': 'Объект USER'}
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
 *          "Id":"Айди встречи",
 *          "Place":"Объект места встречи",
 *          "Creator":"Создатель встречи",
 *          "Users":"Массив объектов пользователей, приглашенных на встречу",
 *          "UserCount" : "Колличество пользователей приглашенных на встречу",
 *          "Start" : "Время начала встречи"
 *     }
 * )
 */
class ConnectController extends \api\components\Controller
{

}
