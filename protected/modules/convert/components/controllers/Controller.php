<?php
namespace convert\components\controllers;

class Controller extends \application\components\controllers\BaseController 
{
  protected $limit = 1000;
  protected $offset;
  private   $data = array();
  protected $step;

  protected function beforeAction($action) 
  {
    $this->step   = \Yii::app()->request->getParam('step', 0);
    $this->offset = $this->limit * $this->step;
    return parent::beforeAction($action);
  }
  
  protected function afterAction($action)
	{
    if (!empty($this->data))
    {
      echo 'Идет процесс конвертации...';
      echo '<meta http-equiv="refresh" content="1; url='.$this->createUrl('/'.$this->module->getName().'/'.$this->getId().'/'.$action->getId()).'?step='.($this->step+1).'">';
    }
    else
    {
      echo 'Конвертация выполнена';
    }
    return parent::afterAction($action);
	}
  
  protected function queryAll($sql)
  {
    $connection = \Yii::app()->dbOld;
    $command = $connection->createCommand();
    $command->Text = $sql.' LIMIT '.$this->offset.','.$this->limit;
    $this->data = $command->queryAll();
    return $this->data;
  }
}

?>
