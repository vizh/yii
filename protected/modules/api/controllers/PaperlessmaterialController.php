<?php

use nastradamus39\slate\annotations\ApiController;
use nastradamus39\slate\annotations\ApiObject;

/**
 * @ApiController(
 *     controller="Paperlessmaterial",
 *     title="Материалы Paperless",
 *     description="Методы для работы с механикой Paperless."
 * )
 * @ApiObject(
 *     code="PAPERLESSMATERIAL",
 *     title="Материал",
 *     json="{
 *         'Id': 1,
 *         'Name': '',
 *         'File': '',
 *         'Comment': true,
 *         'Partner':{
 *             'Name': '',
 *             'Site': '',
 *             'Logo': ''
 *     }",
 *     description="Материал.",
 *     params={
 *         "Id": "Идентификатор",
 *         "Name": "Название",
 *         "Comment": "Комментарий",
 *         "File": "Файл для скачивания",
 *         "Partner":{
 *             "Name": "Название компании-партнёра",
 *             "Site": "Сайт",
 *             "Logo": "Логотип"
 *         }
 *     }
 * )
 */
class PaperlessmaterialController extends \api\components\Controller
{

}
