<?php
namespace ruvents\controllers\visit;

use event\models\section\Hall;
use ruvents\components\Exception;
use user\models\User;

class CreateGroupAction extends \ruvents\components\Action
{
    public function run($hallId, $data)
    {
        $hall = Hall::model()
            ->byEventId($this->getEvent()->Id)
            ->byDeleted(false)
            ->findByPk($hallId);

        if ($hall == null) {
            throw new Exception(701, $hallId);
        }

        $dataJson = json_encode($data);

        if (is_array($dataJson)) {
            foreach ($dataJson as $item) {
                $valid = true;
                $visitDatetime = \DateTime::createFromFormat('Y-m-d H:i:s', $item->VisitTime);
                if ($visitDatetime === false) {
                    $valid = false;
                }

                $user = User::model()
                    ->byRunetId($item->RunetId)
                    ->find();

                if ($user === null) {
                    $valid = false;
                }

                if ($valid) {
                    $visit = new \event\models\section\UserVisit();
                    $visit->UserId = $user->Id;
                    $visit->HallId = $hall->Id;
                    $visit->VisitTime = $visitDatetime->format('Y-m-d H:i:s');
                    $visit->save();
                }
            }
        }

        $this->renderJson(['Success' => true]);
    }
}