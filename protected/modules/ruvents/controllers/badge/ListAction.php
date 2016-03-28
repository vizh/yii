<?php
namespace ruvents\controllers\badge;

use ruvents\components\Exception;

class ListAction extends \ruvents\components\Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $runetId = $request->getParam('RunetId', null);
        //$partId = $request->getParam('PartId', null);

        //todo: для PhDays
        $partId = $request->getParam('PartId', 7);

        $event = $this->getEvent();
        $user = \user\models\User::model()->byRunetId($runetId)->find();
        
        if ($user === null)
            throw new Exception(202, $runetId);

        $badge = \ruvents\models\Badge::model()->byEventId($event->Id)->byUserId($user->Id);
        if (sizeof($event->Parts) > 0) {
            /** @var $part \event\models\Part */
            $part = \event\models\Part::model()->findByPk($partId);
            if ($part === null || $part->EventId != $event->Id) {
                throw new Exception(306, [$partId]);
            }

            $badge->byPartId($part->Id);
        } else {
            $badge->byPartId(null);
        }
        $badges = $badge->with(['Role', 'User'])->findAll();

        $result = [];
        foreach ($badges as $badge) {
            $result[] = $this->getDataBuilder()->createBadge($badge);
        }

        echo json_encode($result);
    }
}
