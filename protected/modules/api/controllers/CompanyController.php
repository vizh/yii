<?php

use nastradamus39\slate\annotations\ApiController;
use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\ApiContent;
use nastradamus39\slate\annotations\ApiError;

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
class CompanyController extends \api\components\Controller
{

}