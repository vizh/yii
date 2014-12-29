<?php

class Ruvents2Module extends CWebModule
{
    public $controllerNamespace = '\ruvents2\controllers';

    protected function init()
    {
        parent::init();

        Yii::app()->setComponent('authManager', [
            'class' => '\ruvents2\components\PhpAuthManager',
            'defaultRoles' => ['guest']
        ]);
    }


    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            // Бездумный, as is, вывод логов в STDOUT будет порождать невалидный JSON. Предотвращаем. Для разработки должно хватать CFileLogRoute.
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
        if ($event->exception instanceof \ruvents2\components\Exception) {
            $event->exception->render();
        } else {
            http_response_code(500);
        }
        $event->handled = true;
        // todo: log exception
    }
}