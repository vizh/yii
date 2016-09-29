<?php

/**
 * Class FailureController
 */
class FailureController extends \application\components\controllers\AdminMainController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => '\pay\controllers\admin\failure\IndexAction',
        ];
    }

}