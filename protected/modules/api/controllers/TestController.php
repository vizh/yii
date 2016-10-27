<?php

use api\components\Controller;

class TestController extends Controller
{
    public function actionIndex()
    {
        $this->setResult(['Success' => true]);
    }
}
