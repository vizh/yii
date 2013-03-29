<?php


class RuventsModule extends CWebModule
{
  public function beforeControllerAction($controller, $action)
  {
    if(parent::beforeControllerAction($controller, $action))
    {
      $this->createLog($controller, $action);
      \Yii::app()->attachEventHandler('onException', array($this, 'onException'));
      return true;
    }
    else
    {
      return false;
    }
  }

  public function createLog(CController $controller, CAction $action)
  {
//    $log = new \ruvents\models\Log();
//    $operator = \ruvents\components\WebUser::Instance()->getOperator();
//    $log->OperatorId = $operator !== null ? $operator->OperatorId : null;
//    $log->Controller = $controller->getId();
//    $log->Action = $action->getId();
//
//    $request = $_REQUEST;
//    $operator = new \ruvents\models\Operator();
//    if (isset($request['Password']))
//    {
//      $request['Password'] = \ruvents\models\Operator::GeneratePasswordHash($request['Password']);
//    }
//    if (isset($request['MasterPassword']))
//    {
//      $request['MasterPassword'] = \ruvents\models\Operator::GeneratePasswordHash($request['MasterPassword']);
//    }
//
//    $log->Request = var_export($request, true) . var_export($_SERVER, true);
//    $log->Time = date('Y-m-d H:i:s');
//    $log->save();
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
  }
}

