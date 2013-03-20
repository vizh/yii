<?php
namespace convert\components\controllers;

class Controller extends \application\components\controllers\BaseController 
{
  protected $limit = 500;
  protected $offset;
  private   $data = array();
  protected $step;
  protected $stepAll;


  protected function beforeAction($action) 
  {
    $this->step   = \Yii::app()->request->getParam('step', 0);
    $this->offset = $this->limit * $this->step;
    return parent::beforeAction($action);
  }
  
  protected function afterAction($action)
	{
    if (!\Yii::app()->request->getIsAjaxRequest())
    {
      if (!empty($this->data))
      {
        echo 'Идет процесс конвертации...';
        echo '<meta http-equiv="refresh" content="1; url='.$this->getNextStepUrl().'">';
      }
      else
      {
        echo 'Конвертация выполнена';
      }
    }
    else
    {
      $result = new \stdClass();
      if (!empty($this->data))
      {
        $result->success = false;
        $result->stepAll = $this->stepAll;
        $result->step    = $this->step;
        $result->nextUrl = $this->getNextStepUrl();
      }
      else
      {
        $result->success = true;
      }
      echo json_encode($result);
    }
    return parent::afterAction($action);
	}
  
  private function getNextStepUrl()
  {
    return $this->createUrl('/'.$this->module->getName().'/'.$this->getId().'/'.$this->action->getId()).'?step='.($this->step+1);
  }


  protected function queryAll($sql)
  {
    $connection = \Yii::app()->dbOld;
    $command = $connection->createCommand();
    
    $command->Text = preg_replace('/SELECT (.*) FROM/i', 'SELECT Count(*) as `Count` FROM', $sql);
    $countQuery = $command->queryRow();
    $this->stepAll = ceil($countQuery['Count'] / $this->limit);
    
    $command->Text = $sql.' LIMIT '.$this->offset.','.$this->limit;  
    $this->data = $command->queryAll();
    return $this->data;
  }
}

?>
