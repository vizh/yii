<?php
class MainController extends \application\components\controllers\BaseController
{
  public function actionIndex($url)
  {
    if (strpos($url,'/widget/') !== 0)
      throw new CHttpException(500);

    $this->layout = '/layouts/public';
    \Yii::app()->getClientScript()->registerPackage('runetid.easyXDM');
    $this->renderText('');
  }
} 