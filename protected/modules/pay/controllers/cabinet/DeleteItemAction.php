<?php
namespace pay\controllers\cabinet;

use pay\models\OrderItem;

class DeleteItemAction extends \pay\components\Action
{
    public function run($orderItemId, $eventIdName)
    {
        $item = OrderItem::model()
            ->findByPk($orderItemId);

        if ($item->Product->EventId === $this->getEvent()->Id && $item->PayerId === $this->getUser()->Id) {
            $item->delete();
        }

        $this->getController()->redirect($this->getController()->createUrl('/pay/cabinet/index'));
    }
}
