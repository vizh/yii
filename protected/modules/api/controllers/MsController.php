<?php

use api\components\Controller;
use nastradamus39\slate\annotations\ApiController;

/**
 * @ApiController(
 *     controller="ms",
 *     title="Microsoft",
 *     description="Спецпроект для Microsoft"
 * )
 */
class MsController extends Controller
{
    public function actions()
    {
        return [
            'checkFastauth' => '\api\controllers\ms\CheckFastauthAction',
            'createUser' => '\api\controllers\ms\CreateUserAction',
            'payUrl' => '\api\controllers\ms\PayUrlAction',
            'search' => '\api\controllers\ms\SearchAction',
            'updateRegistration' => '\api\controllers\ms\UpdateRegistrationAction',
            'updateUser' => '\api\controllers\ms\UpdateUserAction',
            'userLogin' => '\api\controllers\ms\UserLoginAction',
            'users' => '\api\controllers\ms\UsersAction'
        ];
    }
}
