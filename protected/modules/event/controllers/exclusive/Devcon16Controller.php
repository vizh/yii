<?php
use application\components\controllers\PublicMainController;



class Devcon16Controller extends PublicMainController
{
    public function actionProducts()
    {
        $participants = \event\models\Participant::model()->byEventId(2319)
            ->byRoleId(1)
            ->findAll();

        $map = \application\components\helpers\ArrayHelper::map(
            $participants,
            function (\event\models\Participant $participant) {
                $account = \api\models\ExternalUser::model()
                    ->byUserId($participant->UserId)
                    ->byAccountId(335)
                    ->find();

                return $account->ExternalId;
            },
            function (\event\models\Participant $participant) {
                $devcon = [4015,4016,4017,4018];

                $criteria = new \CDbCriteria();
                $criteria->addInCondition('"t"."ProductId"', array_merge($devcon, [4013,4019]));

                $orderItem = \pay\models\OrderItem::model()
                    ->byAnyOwnerId($participant->UserId)
                    ->byEventId($participant->EventId)
                    ->byPaid(true)
                    ->find($criteria);

                return in_array($orderItem->ProductId, $devcon) ? 'DevCon' : $orderItem->Product->Title;
            }
        );

        echo json_encode($map);
    }
}