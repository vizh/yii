<?php

class ErrorController extends \application\components\controllers\PublicMainController
{
  /**
   * Не валидируем для данного контроллера CSRF токен
   * @param $filterChain
   */
  public function filterValidateCsrf($filterChain)
  {
    $filterChain->run();
  }

  public function actionIndex()
  {
    $this->bodyId = 'error-page';
    if($error=Yii::app()->errorHandler->error)
    {
      if ($error['code'] == 404)
      {
        $this->render('error404', array('error' => $error));
      }
      elseif ($error['code'] == 503)
      {
        $this->render('error503', array('error' => $error));
      }
      else
      {
        $this->render('error500', array('error' => $error));
      }
    }
  }
}
