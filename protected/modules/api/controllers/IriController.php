<?php

use api\components\Controller;
use nastradamus39\slate\annotations\ApiController;

/**
 * @ApiController(
 *     controller="Iri",
 *     title="ИРИ",
 *     description=""
 * )
 */
class IriController extends Controller
{
    public function actions()
    {
        return [
            'roles' => '\api\controllers\iri\RolesAction',
            'userAdd' => '\api\controllers\iri\UserAddAction',
            'userDelete' => '\api\controllers\iri\UserDeleteAction',
            'userList' => '\api\controllers\iri\UserListAction'
        ];
    }
}
