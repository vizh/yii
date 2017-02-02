<?php

use nastradamus39\slate\annotations\ApiController;
use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\ApiContent;

/**
 * @ApiController(
 *     controller="Company",
 *     title="Компании",
 *     description="Описаие методов для работы с компаниями"
 * )
 * @ApiContent(
 *     title="Общая информация",
 *     description="
Запрос к методам API представляет собой обращение по HTTP-протоколу к URL вида http://api.runet-id.com/<название метода>.
Переменные методов передаются с помощью GET или POST параметров. В качестве результата возвращается JSON объект.
Для каждого мероприятия генерируются ApiKey и Secret. Доступ к API для каждого ApiKey ограничивается списком ip-адресов.
<strong>Обязательные для всех методов параметры:</strong>
    1. ApiKey
    2. Hash - вычисляется по формуле md5(ApiKey+Secret)
<strong>Формат возвращаемых ошибок:</strong>
{
    Error: {Code: int, Message: string}
}
<strong>При использовании php-API:</strong>
$api = new \RunetID\Api\Api(ApiKey, Secret, Cache = null);
где Cache - объект класса, реализующего интерфейс \RunetID\Api\ICache"
 * )
 */
class CompanyController extends \api\components\Controller
{

}