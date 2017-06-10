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

        if ($error = Yii::app()->getErrorHandler()->getError()) {
            $view = in_array($error['code'], [404, 503])
                ? "error{$error['code']}"
                : 'error500';

            $this->render($view, ['error' => $error]);
        }
    }
}
