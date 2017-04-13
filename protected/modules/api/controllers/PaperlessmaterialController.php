<?php

use nastradamus39\slate\annotations\ApiController;
use nastradamus39\slate\annotations\ApiObject;

/**
 * @ApiController(
 *     controller="Paperlessmaterial",
 *     title="Материалы",
 *     description="Методы для работы со встречами."
 * )
 * @ApiObject(
 *     code="PAPERLESSMATERIAL",
 *     title="Материал",
 *     json="{
 *          'Id': 1,
 *          'Name': '',
 *          'Comment': 'true',
 *          'File': '',
 *          'Active': 'true',
 *          'PartnerName': '',
 *          'PartnerSite': '',
 *          'PartnerLogo': ''
 *     }",
 *     description="Материал.",
 *     params={
 *          "Id": "Айди материала",
 *          "Name": "Название",
 *          "Comment": "Комментарий",
 *          "File": "Файл",
 *          "Active": "Активность",
 *          "PartnerName": "Название партнера",
 *          "PartnerSite": "Сайт партнера",
 *          "PartnerLogo": "Лого партнера"
 *      }
 * )
 */
class PaperlessmaterialController extends \api\components\Controller
{
    
}
