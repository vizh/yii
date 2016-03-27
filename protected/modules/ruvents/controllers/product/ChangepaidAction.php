<?php
namespace ruvents\controllers\product;


use pay\models\OrderItem;
use ruvents\components\Exception;
use user\models\User;

class ChangepaidAction extends \ruvents\components\Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $fromRunetId = $request->getParam('FromRunetId', null);
        $toRunetId = $request->getParam('ToRunetId', null);
        $orderItemIdList = $request->getParam('orderItemIdList', '');
        $orderItemIdList = explode(',', $orderItemIdList);

        if (count($orderItemIdList) === 0)
            throw new Exception(408);

        $fromUser = User::model()
            ->byRunetId($fromRunetId)
            ->find();

        if ($fromUser === null)
            throw new Exception(202, $fromRunetId);

        $toUser = User::model()
            ->byRunetId($toRunetId)
            ->find();

        if ($toUser === null)
            throw new Exception(202, $toRunetId);

        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."Id"', $orderItemIdList);

        $orderItems = OrderItem::model()
            ->byEventId($this->getEvent()->Id)
            ->findAll($criteria);

        if (sizeof($orderItems) == 0)
            throw new Exception(409, implode(',', $orderItemIdList));

        if (sizeof($orderItems) < sizeof($orderItemIdList)) {
            $errorId = [];
            foreach ($orderItemIdList as $id) {
                $flag = true;
                foreach ($orderItems as $item) {
                    if ($item->Id == $id) {
                        $flag = false;
                        break;
                    }
                }
                if ($flag) {
                    $errorId[] = $id;
                }
            }
            throw new Exception(409, implode(',', $errorId));
        }
        $this->checkOwned($orderItems, $fromUser);
        $this->checkProducts($orderItems, $toUser);

        $detailLog = $this->getDetailLog()->createBasic();
        foreach ($orderItems as $item) {
            $this->getDetailLog()->addChangeMessage(new \ruvents\models\ChangeMessage('OrderItem', $item->Id, 0));
            $detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('OrderItem', 0, $item->Id));
            $item->changeOwner($toUser);
        }

        $this->getDetailLog()->UserId = $fromUser->Id;
        $this->getDetailLog()->save();

        $detailLog->UserId = $toUser->Id;
        $detailLog->save();

        echo json_encode(['Success' => true]);
    }


    /**
     * @param OrderItem[] $orderItems
     * @param User $user
     * @throws Exception
     * @return void
     */
    private function checkOwned($orderItems, $user)
    {
        $errorId = [];
        foreach ($orderItems as $item) {
            if (($item->ChangedOwnerId !== null && $item->ChangedOwnerId != $user->Id) ||
                ($item->ChangedOwnerId === null && $item->OwnerId != $user->Id)
            ) {
                $errorId[] = $item->Id;
            }
        }

        if (count($errorId) > 0)
            throw new Exception(413, implode(',', $errorId));
    }

    /**
     * @param OrderItem[] $orderItems
     * @param User $user
     * @throws Exception
     * @return void
     */
    private function checkProducts($orderItems, $user)
    {
        $errorId = [];

        foreach ($orderItems as $item)
            if (!$item->Product->getManager()->checkProduct($user))
                $errorId[] = $item->Id;

        if (count($errorId) > 0)
            throw new Exception(414, implode(',', $errorId));
    }
}