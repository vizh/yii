<?php

class RuventsModule extends CWebModule
{
  public function beforeControllerAction($controller, $action)
  {
    if (parent::beforeControllerAction($controller, $action))
    {
      // Бездумный, as is, вывод логов в STDOUT будет порождать невалидный JSON. Предотвращаем. Для разработки должно хватать CFileLogRoute.
      foreach (\Yii::app()->log->routes as $route)
        if ($route instanceof \CWebLogRoute)
          $route->enabled = false;

      \Yii::app()->attachEventHandler('onException', array($this, 'onException'));
      return true;
    }

    return false;
  }

  /**
   * @param CExceptionEvent $event
   */
  public function onException($event)
  {
    if ($event->exception instanceof \ruvents\components\Exception)
    {
      /** @var $exception \ruvents\components\Exception */
      $exception = $event->exception;
    }
    else
    {
      $exception = new \ruvents\components\Exception(601, array($event->exception->getMessage()));
    }
    $exception->sendResponse();
    $event->handled = true;

    /** @var \ruvents\components\Controller $controller */
    $controller = \Yii::app()->getController();
    $log = $controller->createLog();
    if ($log !== null)
    {
      $log->ErrorCode = $exception->getCode();
      $log->ErrorMessage = $exception->getMessage();
      $log->save();
    }
  }
}

