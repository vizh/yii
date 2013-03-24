<?php
namespace partner\controllers\orderitem;

class ActivateAjaxAction extends \partner\components\Action
{
  public function run()
  {
    if (\Yii::app()->request->getIsAjaxRequest())
    {
      $result = new \stdClass();
      $action = \Yii::app()->request->getParam('action');
      $orderItemId = (int) \Yii::app()->request->getParam('orderItemId');

      if ($orderItemId > 0)
      {
        switch ($action)
        {
          case 'activate':
            $result->success = $this->AjaxOrderItemActivate($orderItemId);
            break;

          case 'deactivate':
            $result->success = $this->AjaxOrderItemDeActivate($orderItemId);
            break;
        }
      }
      echo json_encode($result);
      exit();
    }
  }
  
  /**
   * Активация оплаты
   * @param int $orderItemId 
   */
  private function AjaxOrderItemActivate ($orderItemId)
  {
    $orderItem = \pay\models\OrderItem::GetById($orderItemId);
    if ($orderItem !== null)
    {
      $result = $orderItem->Product->ProductManager()->BuyProduct($orderItem->Owner, $orderItem->getParamsArray());
      if ($result)
      {
        $orderItem->Paid = 1;
        $orderItem->PaidTime = date('Y-m-d H:i:s');
        $orderItem->Deleted = 0;
        $orderItem->save();
        return true;
      }
    }
    return false;
  }
    
  /**
    * Деактивация оплаты
    * @param int $orderItemId 
    */
  private function AjaxOrderItemDeActivate ($orderItemId)
  {
    $orderItem = \pay\models\OrderItem::GetById($orderItemId);
    if ($orderItemId !== null)
    {
      $orderItem->Product->ProductManager()->RollbackProduct($orderItem->Owner);
      return true;
    }
    return false;
  }
}
