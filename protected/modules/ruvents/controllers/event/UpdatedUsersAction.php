<?php
namespace ruvents\controllers\event;

use ruvents\components\Exception;
use user\models\User;
use ruvents\models\Badge;
use pay\models\OrderItem;
use api\models\ExternalUser;
use api\models\Account;

/**
 * Class UpdatedUsersAction
 */
class UpdatedUsersAction extends \ruvents\components\Action
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        ini_set('memory_limit', '512M');

        $request = \Yii::app()->getRequest();
        $fromUpdateTime = $request->getParam('FromUpdateTime');
        $byPage = $request->getParam('Limit', 200);
        $needCustomFormat = $request->getParam('CustomFormat', false) == '1';
        
        if (empty($fromUpdateTime))
            throw new Exception(900, ['FromUpdateTime']);

        $fromUpdateTime = date('Y-m-d H:i:s', strtotime($fromUpdateTime));
        $nextUpdateTime = date('Y-m-d H:i:s');

        $pageToken = $request->getParam('PageToken', null);
        $offset = 0;
        if ($pageToken) {
            $offset = $this->getController()->parsePageToken($pageToken);
        }

        $users = User::model()->findAll($this->makeUserCriteria($fromUpdateTime, $byPage, $offset));
        $idList = [];
        foreach ($users as $user) {
            $idList[] = $user->Id;
        }

        $orderItems = $this->getOrderItems($idList);
        $badgesCount = $this->getBadgesCount($idList);
        $externalList = $this->getExternalIds($idList);

        $result = [];
        $result['Users'] = [];
        foreach ($users as $user) {
            $this->getDataBuilder()->createUser($user);
            $this->getDataBuilder()->buildUserEmployment($user);
            $this->getDataBuilder()->buildUserPhone($user);
            $this->getDataBuilder()->buildUserData($user);
            $resultUser = $this->getDataBuilder()->buildUserEvent($user);

            if (isset($orderItems[$user->Id])) {
                $resultUser->PaidItems = array();
                foreach ($orderItems[$user->Id] as $item) {
                    $order = $this->getDataBuilder()->createOrderItem($item);

                    if ($needCustomFormat) {
                        $customOrder = (object)array(
                            'OrderItemId' => $item->Id,
                            'ProductId' => $order->Product->ProductId,
                            'ProductTitle' => $order->Product->Title,
                            'Price' => $order->Product->Price
                        );

                        if ($order->PromoCode) $customOrder->PromoCode = $order->PromoCode;
                        if ($order->PayType) $customOrder->PayType = $order->PayType;
                        if ($order->Product->Manager) $customOrder->ProductManager = $order->Product->Manager;
                        if ($item->Product->ManagerName == 'RoomProductManager') $customOrder->Lives = $item->Product->getManager()->Hotel;

                        $order = $customOrder;
                    }

                    $resultUser->PaidItems[] = $order;
                }
            }
            $resultUser->BadgeCount = isset($badgesCount[$user->Id]) ? $badgesCount[$user->Id] : 0;
            $resultUser->ExternalId = isset($externalList[$user->Id]) ? $externalList[$user->Id] : null;
            $result['Users'][] = $resultUser;
        }

        if (sizeof($users) == $byPage) {
            $result['NextPageToken'] = $this->getController()->getPageToken($offset + $byPage);
        }

        if (empty($pageToken)) {
            $result['NextUpdateTime'] = $nextUpdateTime;
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    private function getBadgesCount($idList)
    {
        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."UserId"', $idList);
        /** @var Badge[] $badges */
        $badges = Badge::model()
            ->byEventId($this->getEvent()->Id)
            ->findAll($criteria);

        $badgesCount = [];
        foreach ($badges as $badge) {
            if (!isset($badgesCount[$badge->UserId])) {
                $badgesCount[$badge->UserId] = 0;
            }
            $badgesCount[$badge->UserId]++;
        }

        return $badgesCount;
    }

    private function getOrderItems($idList)
    {
        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."OwnerId"', $idList);
        $criteria->addCondition('"t"."ChangedOwnerId" IS NULL');
        $criteria->addInCondition('"t"."ChangedOwnerId"', $idList, 'OR');

        $orderItems = OrderItem::model()
            ->byEventId($this->getEvent()->Id)
            ->byPaid(true)
            ->findAll($criteria);

        $result = [];
        foreach ($orderItems as $item) {
            $ownerId = $item->ChangedOwnerId === null ? $item->OwnerId : $item->ChangedOwnerId;
            $result[$ownerId][] = $item;
        }

        return $result;
    }

    private function getExternalIds($idList)
    {
        $result = [];
        if ($apiAccount = Account::model()->byEventId($this->getEvent()->Id)->find()) {
            $criteria = new \CDbCriteria();
            $criteria->addInCondition('t."UserId"', $idList);

            $externals = ExternalUser::model()
                ->byAccountId($apiAccount->Id)
                ->findAll($criteria);

            foreach ($externals as $external) {
                $result[$external->UserId] = $external->ExternalId;
            }
        }

        return $result;
    }

    /**
     * Makes the user criteria
     * @param string $fromUpdateTime
     * @param int $byPage
     * @param int $offset
     * @return \CDbCriteria
     */
    private function makeUserCriteria($fromUpdateTime, $byPage, $offset)
    {
        $criteria = new \CDbCriteria();
        $criteria->with = [
            'Participants' => [
                'on' => '"Participants"."EventId" = :EventId',
                'params' => [
                    'EventId' => $this->getEvent()->Id
                ],
                'together' => false
            ],
            'Employments' => ['together' => false],
            'Employments.Company' => ['together' => false],
            'LinkPhones.Phone' => ['together' => false]
        ];
        $criteria->order = '"t"."Id" ASC';
        $criteria->addCondition('"t"."UpdateTime" > :UpdateTime');
        $criteria->params['UpdateTime'] = $fromUpdateTime;
        $criteria->addCondition(
            '"t"."Id" IN (SELECT "EventParticipant"."UserId" FROM "EventParticipant" WHERE "EventParticipant"."EventId" = ' . $this->getEvent()->Id . ')'
        );

        $criteria->limit = $byPage;
        $criteria->offset = $offset;

        return $criteria;
    }
}