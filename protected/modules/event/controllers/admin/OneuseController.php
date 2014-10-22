<?php

class OneuseController extends \application\components\controllers\AdminMainController
{
    public function actionCreators()
    {
        return;
        /** @var \event\models\Event[] $events */
        $events = \event\models\Event::model()->findAll('"t"."External"');

        $emails = [];
        $runetIds = [];
        foreach ($events as $event)
        {
            if (isset($event->ContactPerson))
            {
                $contact = unserialize($event->ContactPerson);
                if (isset($contact['Email']))
                {
                    $emails[] = $contact['Email'];
                }
                if (isset($contact['RunetId']))
                {
                    $runetIds[] = $contact['RunetId'];
                }
            }
        }

        $criteria = new CDbCriteria();
        $criteria->addInCondition('"t"."RunetId"', $runetIds);
        $criteria->addInCondition('"t"."Email"', $emails, 'OR');
        $criteria->addCondition('"t"."Email" != \'alaris.nik@gmail.com\'');
        $criteria->with = [
            'Participants' => ['together' => true, 'on' => '"Participants"."EventId" = 425']
        ];
        $criteria->order = '"t"."RunetId"';
        $users = \user\models\User::model()->findAll($criteria);

        echo '<table>';
        foreach ($users as $user)
        {
            $this->printUserInfo($user);
        }
        echo '</table>';
    }

    public function actionCreators2()
    {
        echo 'closed';
        return;
        $positions = [
            '%Основатель%', '%Co-founder%', '%Президент%', '%Директор%',
            '%Руководитель%', '%PR%', 'Менеджер проектов', '%Маркетинг%',
            '%Marketing%', '%Event%', '%Эвент%'
        ];
        $positions = '\''.implode('\', \'',  $positions ).'\'';

        $exclude = ['%тех%', '%арт%'];
        $exclude = '\''.implode('\', \'',  $exclude ).'\'';

        $criteria = new CDbCriteria();
        $criteria->addCondition('"Employments"."Position" ~~* ANY(array['.$positions.'])');
        $criteria->addCondition('"Employments"."Primary"');
        $criteria->addCondition('"Employments"."Position" !~~* ALL(array['.$exclude.'])');
        $criteria->with = ['Employments' => ['together' => true]];


        $users = \user\models\User::model()->byEventId(425)->findAll($criteria);

        echo sizeof($users);

        $product = \pay\models\Product::model()->findByPk(1421);

        foreach ($users as $user)
        {
            //$item = $product->getManager()->createOrderItem($user, $user);
            //$item->Paid = true;
            //$item->PaidTime = date('Y-m-d H:i:s');
            //$item->save();
        }

//    echo '<table>';
//    foreach ($users as $user)
//    {
//      $this->printUserInfo($user);
//    }
//    echo '</table>';
    }

    public function actionUexproducts()
    {
        return;
        $eventId = 652;

        $criteria = new CDbCriteria();
        $criteria->addCondition('"t"."Controller" = :c1 AND "t"."Action" = :a1');
        $criteria->addCondition('"t"."Controller" = :c2 AND "t"."Action" = :a2', 'OR');
        $criteria->addCondition('"t"."EventId" = :EventId');
        $criteria->params = ['c1' => 'event', 'a1' => 'register', 'c2' => 'user', 'a2' => 'create', 'EventId' => $eventId];

        $model = \ruvents\models\DetailLog::model();

        /** @var \ruvents\models\DetailLog[] $logs */
        $logs = $model->findAll($criteria);

        $usersId = [];

        foreach ($logs as $log)
        {
            $messages = $log->getChangeMessages();

            foreach ($messages as $message)
            {
                if ($message->key == 'Role' && $message->to == 1)
                {
                    $usersId[] = $log->UserId;
                }
            }

        }

        $participants = \event\models\Participant::model()
            ->byEventId($eventId)->byRoleId(1)->byPartId(19)
            ->findAll([
                'with' => ['User' => ['together' => true]],
                'order' => '"User"."LastName"'
            ]);
        $count = 0;
        echo '<table>';
        foreach ($participants as $participant)
        {
            if (!in_array($participant->UserId, $usersId))
            {
                $this->printUserInfo($participant->User);
                $count++;
            }
        }
        echo '</table>';

        echo $count;
    }

    /**
     * @param \user\models\User $user
     */
    private function printUserInfo($user)
    {
        $data = [];
        $data[] = $user->RunetId;
        $data[] = $user->getFullName();
        //$data[] = $user->Email;
        if ($user->getEmploymentPrimary() != null)
        {
            $data[] = $user->getEmploymentPrimary()->Company->Name;
            $data[] = $user->getEmploymentPrimary()->Position;
        }
        else
        {
            $data[] = '';
            $data[] = '';
        }
//    if (!empty($user->Participants))
//    {
//      $data[] = $user->Participants[0]->Role->Title;
//    }
//    else
//    {
//      $data[] = 'не участвует';
//    }
        echo '<tr><td>' . implode('</td><td>', $data) . '</td></tr>';
    }

    public function actionPlog()
    {
        return;
        $eventId = 831;

        $sql = 'SELECT ep.* FROM "EventParticipant" ep

LEFT JOIN "EventParticipantLog" epl ON ep."EventId" = epl."EventId" AND ep."UserId" = epl."UserId"

WHERE epl."Id" IS NULL AND ep."EventId" = 831';

        $command = Yii::app()->getDb()->createCommand();
        $result = $command->select('ep.*')->from('EventParticipant ep')
            ->leftJoin('EventParticipantLog epl', 'ep."EventId" = epl."EventId" AND ep."UserId" = epl."UserId"')
            ->where('epl."Id" IS NULL AND ep."EventId" = :EventId')->query(['EventId' => $eventId]);

        foreach ($result as $row)
        {
            $pl = new \event\models\ParticipantLog();
            $pl->EventId = $row['EventId'];
            $pl->PartId = $row['PartId'];
            $pl->UserId = $row['UserId'];
            $pl->RoleId = $row['RoleId'];
            $pl->CreationTime = $row['CreationTime'];
            //$pl->save();
        }

        echo 'Done';

    }

    public function actionUefood()
    {
        $eventId = 1309;
        $userIdList = [];

        $orderItems = \pay\models\OrderItem::model()->byEventId($eventId)->byPaid(true)->findAll();
        foreach ($orderItems as $orderItem) {
            if ($orderItem->getPriceDiscount() > 0) {
                $userIdList[] = $orderItem->ChangedOwnerId !== null ? $orderItem->ChangedOwnerId : $orderItem->OwnerId;
            }
        }

        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."RoleId"', [3,6]);
        $participants = \event\models\Participant::model()->byEventId($eventId)->findAll($criteria);
        foreach ($participants as $participant) {
            $userIdList[] = $participant->UserId;
        }

        $coupons = [
            '3y7M0vnn9EMf',
            '3F4109g89qz1',
            '3gbe0yne9sdt',
            '3yxn0PSf9sna',
            '36KG0a139vpj',
            '3eq10egc9rH1',
            '3f0c0fbj9apR',
            '3zvq0vKm9v56',
            '39wm06fc9265',
            '3ymP0z639vw4',
            '3xvy0bxr9nx0',
            '3B0B07wa9Mce',
            '37Ty0ahY9qj1',
            '3t620gi59jIw',
            '3yeP02c79xqi',
            '3uim0zvb9Sqi',
            '3gcn0dwz9M9c',
            '3eE20kM79UAm',
            '3u6u0uyi9i73',
            '3f8z06km9TU0',
            '3mux0Ah79Ixg',
            '362t0N3v9kw5',
            '3Z0i04Mm9dbh',
            '3isj099K9bu5',
            '3tiT00qi95x6',
            '3kfa017D90Rt',
            '3xP70rib9xkd',
            '33sm0jvk92im',
            '3qdy0zmQ98g7',
            '3E170p3997yt',
            '39Cx0wuT9rdy',
            '37210vhx9q8n',
            '35wz0hvy9bGe',
            '3sjx0Vbz9v8j',
            '3c6u0s479tv9',
            'USEREXP2014_trud30',
            'USEREXP2014_GOS',
            'USEREXP2014_PARTNER',
            'USEREXP2014_CLIENT',
            '3Y5c04vh9u44',
            '37uq0hxv90p6',
            '34m00bP3916j',
            '383b0x749EVf',
            '3wJb0pp19jpu',
        ];

        foreach ($coupons as $code) {
            $coupon = \pay\models\Coupon::model()->byEventId($eventId)->byCode($code)->find();
            if ($coupon == null) {
                exit;
            }

            $criteria = new \CDbCriteria();
            $criteria->addCondition('"t"."CouponId" = :CouponId');
            $criteria->params['CouponId'] = $coupon->Id;
            $activations = \pay\models\CouponActivation::model()->byEventId($eventId)->findAll($criteria);
            foreach ($activations as $activation) {
                $userIdList[] = $activation->UserId;
            }

        }

        $propductIdList = [3051,3052];

        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."Id"', $propductIdList);
        $products = \pay\models\Product::model()->byEventId($eventId)->findAll($criteria);

        $userIdList = array_unique($userIdList);
        foreach ($userIdList as $userId) {
            $user = \user\models\User::model()->findByPk($userId);
            if ($user == null)
                exit;

            foreach ($products as $product) {
                if (!\pay\models\OrderItem::model()->byOwnerId($user->Id)->byProductId($product->Id)->exists()) {
                    $product->getManager()->createOrderItem($user, $user);
                }
            }
        }

        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."OwnerId"', $userIdList);
        $criteria->addInCondition('"t"."ProductId"', $propductIdList);
        $orderItems = \pay\models\OrderItem::model()->byPaid(false)->findAll($criteria);
        foreach ($orderItems as $orderItem) {
            $orderItem->activate();
        }
        echo 'ОК! '.sizeof($orderItems);
    }
}