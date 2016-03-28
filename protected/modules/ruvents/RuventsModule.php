<?php

use ruvents\components\Exception;

class RuventsModule extends CWebModule
{
    /**
     * @inheritdoc
     */
    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            // Бездумный, as is, вывод логов в STDOUT будет порождать невалидный JSON. Предотвращаем.
            // Для разработки должно хватать CFileLogRoute.
            foreach (\Yii::app()->log->routes as $route) {
                if ($route instanceof \CWebLogRoute) {
                    $route->enabled = false;
                }
            }

            \Yii::app()->attachEventHandler('onException', [$this, 'onException']);

            return true;
        }

        return false;
    }

    /**
     * @param CExceptionEvent $event
     */
    public function onException($event)
    {
        if (\Yii::app()->getController()->id === 'stat') {
            return;
        }

        if ($event->exception instanceof Exception) {
            /** @var $exception Exception */
            $exception = $event->exception;
        } else {
            $exception = new Exception(601, $event->exception->getMessage());
        }
        $exception->sendResponse();
        $event->handled = true;

        /** @var \ruvents\components\Controller $controller */
        $controller = \Yii::app()->getController();
        $log = $controller->createLog();
        if ($log !== null) {
            $log->ErrorCode = $exception->getCode();
            $log->ErrorMessage = $exception->getMessage();
            $log->save();
        }
    }
}
