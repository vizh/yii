<?php
class DefaultController extends \application\components\controllers\PublicMainController
{
	public function actionIndex()
	{
//    echo '---';
//    print_r(\Yii::app()->getClientScript()->corePackages);
//    print_r(\Yii::app()->getClientScript()->scripts);

    //\Yii::app()->getClientScript()->registerPackage('jquery');

    \Yii::app()->getClientScript()->registerPackage('highcharts');

    //\Yii::app()->getClientScript()->registerScriptFile('jquery');

    $this->render('index');
	}
}