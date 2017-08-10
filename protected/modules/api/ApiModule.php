<?php

class ApiModule extends CWebModule
{
    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            Yii::app()->attachEventHandler('onException', [$this, 'onException']);

            return true;
        }

        return false;
    }

    /**
     * @param CExceptionEvent $event
     */
    public function onException($event)
    {
        $exception = $event->exception instanceof \api\components\Exception
            ? $event->exception
            : new \api\components\Exception(100, [$event->exception->getMessage()]);

        // Перенаправляем ошибку в Sentry
        if (YII_DEBUG === false) {
            Yii::app()->getErrorHandler()
                ->getRavenClient()
                ->captureException($exception);
        }

        $exception->sendResponse();

        $event->handled = true;

        if (YII_DEBUG === false) {
            /** @var \api\components\Controller $controller */
            $controller = Yii::app()->getController();

            $controller->createLog(
                $exception->getCode(),
                $exception->getMessage()
            );
        }

        Yii::app()->end();
    }
}
