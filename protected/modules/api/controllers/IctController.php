<?php

use api\components\Controller;
use nastradamus39\slate\annotations\ApiController;

/**
 * @ApiController(
 *     controller="Ict",
 *     title="ICT"
 * )
 */
class IctController extends Controller
{
    public function actions()
    {
        return [
            'roles' => '\api\controllers\ict\RolesAction',
            'userAdd' => '\api\controllers\ict\UserAddAction',
            'userDelete' => '\api\controllers\ict\UserDeleteAction',
            'userList' => '\api\controllers\ict\UserListAction'
        ];
    }
}
