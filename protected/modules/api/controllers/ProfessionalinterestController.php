<?php

use api\components\Controller;
use nastradamus39\slate\annotations\ApiController;

/**
 * @ApiController(
 *     controller="Interests",
 *     title="Профессиональные интересы",
 *     description=""
 * )
 */
class ProfessionalinterestController extends Controller
{
    public function actions()
    {
        return [
            'add' => '\api\controllers\professionalinterest\AddAction',
            'delete' => '\api\controllers\professionalinterest\DeleteAction',
            'list' => '\api\controllers\professionalinterest\ListAction'
        ];
    }
}
