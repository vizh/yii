<?php

class DefaultController extends \application\components\controllers\BaseController
{
	public function actionIndex()
	{
    $this->render('index');
	}
}