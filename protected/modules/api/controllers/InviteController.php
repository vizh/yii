<?php

use api\components\Controller;
use nastradamus39\slate\annotations\ApiController;

/**
 * @ApiController(
 *     controller="Invite",
 *     title="Приглашения на мероприятия",
 *     description="Приглашения на мероприятия."
 * )
 */
class InviteController extends Controller
{
    public function actions()
    {
        return [
            'get' => '\api\controllers\invite\GetAction',
            'request' => '\api\controllers\invite\RequestAction'
        ];
    }
}
