<?php

use nastradamus39\slate\annotations\ApiController;
use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\ApiContent;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;

/**
 * @ApiContent(
 *     title="Общие параметры",
 *     description="
<b>Общие параметры для всех методов</b>
Language – переключение языка приложения и его ответов в “ru” или “en”. По-умолчанию, значение устанавливается в 'ru'."
 * )
 * @ApiController(
 *     controller="User",
 *     title="Пользователи",
 *     description="Загрузка данных пользователя. Работа с пользователями."
 * )
 */
class UserController extends \api\components\Controller
{

}