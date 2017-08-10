<?php

use api\components\Controller;
use nastradamus39\slate\annotations\ApiController;

/**
 * @ApiController(
 *     controller="Raek",
 *     title="РАЭК",
 *     description="РАЭК."
 * )
 */
class RaecController extends Controller
{
    public function actions()
    {
        return [
            'commissionList' => '\api\controllers\raec\CommissionListAction',
            'commissionUsers' => '\api\controllers\raec\CommissionUsersAction'
        ];
    }
}
