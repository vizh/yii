<?php

class ViewController extends \application\components\controllers\PublicMainController
{
    public $bodyId = 'user-account';

    public function actions()
    {
        return [
            'index' => 'user\controllers\view\IndexAction'
        ];
    }

}
