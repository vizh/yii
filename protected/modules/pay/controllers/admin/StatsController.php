<?php

/**
 * Class StatsController
 */
class StatsController extends \application\components\controllers\AdminMainController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => '\pay\controllers\admin\stats\IndexAction',
        ];
    }

}