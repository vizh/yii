<?php

class CallbackController extends CController
{
  public function actionIndex()
  {
    try
    {
      \pay\components\SystemRouter::Instance()->parseSystemCallback();
    }
    catch (\pay\components\Exception $e)
    {
      \pay\components\SystemRouter::logError($e->getMessage(), $e->getCode());
      header('Status: 500');
      exit();
    }
  }
}
