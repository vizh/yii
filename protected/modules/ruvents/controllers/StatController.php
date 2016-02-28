<?php

use application\components\controllers\PublicMainController;

/**
 * Class StatController Shows statistics for ruvents module
 */
class StatController extends PublicMainController
{
    public function actions()
    {
        return [
            'food' => 'ruvents\controllers\stat\FoodAction'
        ];
    }
}
