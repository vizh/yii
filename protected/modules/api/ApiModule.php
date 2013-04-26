<?php

class ApiModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
//		$this->setImport(array(
//			'api.models.*',
//			'api.components.*',
//		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here

      \Yii::app()->attachEventHandler('onException', array($this, 'onException'));

			return true;
		}
		else
			return false;
	}


  /**
   * @param CExceptionEvent $event
   */
  public function onException($event)
  {
    if ($event->exception instanceof \api\components\Exception)
    {
      /** @var $exception \api\components\Exception */
      $exception = $event->exception;
    }
    else
    {
      $exception = new \api\components\Exception(100, array($event->exception->getMessage()));
    }
    $exception->sendResponse();
    $event->handled = true;
  }
}
