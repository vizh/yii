<?php

use nastradamus39\slate\annotations\ApiController;
use nastradamus39\slate\annotations\ApiObject;

/**
 * @ApiController(
 *     controller="Event",
 *     title="Мероприятия",
 *     description="Методы для работы с мероприятиями."
 * )
 * @ApiObject(
 *     code="HALL",
 *     title="Зал",
 *     json="{'Id': 'идентификатор','Title': 'название зала','UpdateTime': 'время последнего обновления зала (Y-m-d H:i:s)','Order': 'порядок вывода залов', 'Deleted': 'true - если зал удален, false - иначе.' }",
 *     description="Зал.",
 *     params={
 *          "Id":"идентификатор",
 *          "Title":"название зала",
 *          "UpdateTime":"время последнего обновления зала",
 *          "Order":"порядок вывода залов",
 *          "Deleted" : "true - если зал удален, false - иначе"
 *     }
 * )
 * @ApiObject(
 *     code="EVENT",
 *     title="Мероприятие",
 *     json="{
            'EventId': 245,
            'IdName': 'rif12',
            'Name': 'РИФ+КИБ 2012',
            'Title': 'РИФ+КИБ 2012',
            'Info': 'Крупнейшее весеннее мероприятие интернет-отрасли пройдет с 18 по 20 апреля 2012 года.',
            'Url': 'http://2012.russianinternetforum.ru',
            'UrlRegistration': '',
            'UrlProgram': '',
            'StartYear': 2012,
            'StartMonth': 4,
            'StartDay': 18,
            'EndYear': 2012,
            'EndMonth': 4,
            'EndDay': 20,
            'Image': {
                'Mini': 'http://runet-id.dev/files/event/rif12/50.png',
                'MiniSize': {
                    'Width': 49,
                    'Height': 21
                },
            'Normal': 'http://runet-id.dev/files/event/rif12/120.png',
            'NormalSize': {
                'Width': 120,
                'Height': 51
            }
        },
        'Menu': [{'Type': 'program','Title': 'Программа'}],
        'Statistics': {
            'Participants': {
                'ByRole': {'1': 3796,'2': 209,'3': 500,'5': 424,'6': 26,'14': 8,'22': 31,'24': 5306,'25': 32,'26': 4,'29': 63},
                'TotalCount': 10399
            }
        },
        'FullInfo': '<p>Главное весеннее мероприятие ИТ-отрасли традиционно проходит в выездном формате.'
}",
 *     description="Информация о мероприятии.",
 *     params={
 *
 *     }
 * )
 * @ApiObject(
 *     code="EVENTROLE",
 *     title="Статус на мероприятии",
 *     json="{'RoleId': 'идентификатор статуса на мероприятии','RoleTitle': 'название статуса','UpdateTime': 'время последнего обновления'}",
 *     description="Статус на мероприятии.",
 *     params={
 *
 *     }
 * )
 */
class EventController extends \api\components\Controller
{


}
