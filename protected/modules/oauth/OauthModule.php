<?php
class OauthModule extends CWebModule 
{
  public function beforeControllerAction($controller, $action) 
  {
    if(parent::beforeControllerAction($controller, $action))
    {
      //\Yii::app()->errorHandler->errorAction = 'main/error';
      return true;
    }
    else
    {
      return false;
    }
  }
}
