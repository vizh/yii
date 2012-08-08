<?php

class DefaultController extends \application\components\controllers\BaseController
{
	public function actionIndex()
	{

    \Yii::app()->clientScript->registerCssFile(
      \Yii::app()->assetManager->publish('css', 'AllCss') . '/main.css'
    );

		$this->render('index');
	}
}