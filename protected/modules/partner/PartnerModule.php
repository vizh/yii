<?php

class PartnerModule extends CWebModule
{

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			return true;
		}
		else
			return false;
	}

  public function afterControllerAction($controller, $action)
  {
    parent::afterControllerAction($controller, $action);
//
//    echo 'Executiontime:' . Yii::getLogger()->executionTime . '<br>';
//
//    echo 'Memory:' . Yii::getLogger()->getMemoryUsage() . '<br>';
//
//    $logs = Yii::getLogger()->getProfilingResults();
//
//    echo '<pre>';
//    var_dump($logs);
//    echo '</pre>';
  }


}
