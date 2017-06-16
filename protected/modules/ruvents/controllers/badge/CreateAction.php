<?php
namespace ruvents\controllers\badge;

use ruvents\components\Exception;
use Yii;

class CreateAction extends \ruvents\components\Action
{
    public function run()
    {
        $request = Yii::app()->getRequest();
        $runetId = $request->getParam('RunetId', null);
        //$partId = $request->getParam('PartId', null);

        Yii::log(sprintf('Печать бейджа для RunetId:%d', $runetId));

        //todo: для PHDays
        //$partId = $request->getParam('PartId', 18);

        $event = $this->getEvent();
        $user = \user\models\User::model()->byRunetId($runetId)->find();

        if ($user === null) {
            throw new Exception(202, $runetId);
        }

        $badge = new \ruvents\models\Badge();
        $badge->OperatorId = $this->getOperator()->Id;
        $badge->EventId = $event->Id;
        $badge->UserId = $user->Id;

        $participant = \event\models\Participant::model()->byEventId($event->Id)->byUserId($user->Id);
//    if (sizeof($event->Parts) > 0)
//    {
//      /** @var $part \event\models\Part */
//      $part = \event\models\Part::model()->findByPk($partId);
//      if ($part === null || $part->EventId != $event->Id)
//      {
//        throw new \ruvents\components\Exception(306, array($partId));
//      }
//
//      $badge->PartId = $part->Id;
//      $participant->byPartId($part->Id);
//    }
//    else
//    {
//      $participant->byPartId(null);
//    }

        if (count($event->Parts) > 0) {
            $participants = $participant->findAll();
            if (count($participants) == 0) {
                throw new Exception(304);
            }
            $participant = null;
            foreach ($participants as $p) {
                if ($participant == null || $participant->Role->Priority < $p->Role->Priority) {
                    $participant = $p;
                }
                $p->UpdateTime = date('Y-m-d H:i:s');
                $p->save();
            }
        } else {
            $participant = $participant->find();
            if (empty($participant)) {
                throw new Exception(304);
            }
//      $participant->UpdateTime = date('Y-m-d H:i:s');
            $participant->save();
        }

        $badge->RoleId = $participant->RoleId;
        $badge->save();

        $this->renderJson([
            'Success' => true
        ]);
    }
}
