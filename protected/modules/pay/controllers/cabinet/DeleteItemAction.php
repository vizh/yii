<?php
namespace pay\controllers\cabinet;

class DeleteItemAction extends \pay\components\Action
{
  public function run($orderItemId, $eventIdName)
  {
    /** @var $item \pay\models\OrderItem */
    $item = \pay\models\OrderItem::model()->findByPk($orderItemId);
    if ($item->Product->EventId == $this->getEvent()->Id && $item->PayerId == $this->getUser()->Id)
    {
      $item->delete();
    }
    $this->getController()->redirect($this->getController()->createUrl('/pay/cabinet/index'));
  }
}
