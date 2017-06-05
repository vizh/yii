<?php
namespace partner\controllers\internal;

class Tc12optionAction extends \CAction
{
    public function run()
    {
        return;
        $eventId = 391;
        if (\Yii::app()->partner->getAccount()->EventId != $eventId) {
            return;
        }
        /** @var $participants \event\models\Participant[] */
        $participants = \event\models\Participant::model()->byEventId($eventId)->findAll();

        $temp = 0;
        foreach ($participants as $participant) {
            if ($participant->RoleId == 2) {
                $optionId = 730;
            } else {
                $optionId = 729;
            }
            $optionOrderItem = \pay\models\OrderItem::model()->byProductId($optionId)->byPayerId($participant->UserId)->byOwnerId($participant->UserId)->find();
            if (empty($optionOrderItem) || $optionOrderItem->Paid == 0) {
                if (empty($optionOrderItem)) {
                    $optionOrderItem = new \pay\models\OrderItem();
                    $optionOrderItem->PayerId = $participant->UserId;
                    $optionOrderItem->OwnerId = $participant->UserId;
                    $optionOrderItem->ProductId = $optionId;
                    $optionOrderItem->CreationTime = date('Y-m-d H:i:s');
                }
                $optionOrderItem->Paid = 1;
                $optionOrderItem->PaidTime = date('Y-m-d H:i:s');
                $optionOrderItem->Deleted = 0;
                $optionOrderItem->save();

                $temp++;
            }
        }

        echo $temp;
    }
}
