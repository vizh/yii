<?php
namespace ruvents\controllers\event;

use event\models\Part;
use event\models\Participant;
use ruvents\components\Exception;
use ruvents\models\ChangeMessage;
use user\models\User;

class UnregisterAction extends \ruvents\components\Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $runetId = $request->getParam('RunetId', null);
        $partId = $request->getParam('PartId', null);


        $event = $this->getEvent();
        $user = User::model()
            ->byRunetId($runetId)
            ->find();
        
        if ($user === null)
            throw new Exception(202, $runetId);

        $participant = Participant::model()
            ->byEventId($event->Id)
            ->byUserId($user->Id);
        
        $part = null;

        /**
         * Если мероприятие многопартийное, но с какой именно части разрегистрировать посетителя не сказано,
         * то отменяем его регистрацию на все части.
         */
        if (count($event->Parts) > 0 && !$partId) {
            $event->unregisterUserOnAllParts($user);
            $this->getDetailLog()->addChangeMessage(new ChangeMessage('Role', '', 'Отмена участия со всех частей.'));
            $this->renderJson(['Success' => true]);

            return;
        }

        // дальше, сюда, пока алгоритм не пройдёт. можно не париться

        if (sizeof($event->Parts) > 0) {
            $part = Part::model()->findByPk($partId);
            if (!$part)
                throw new Exception(306, [$partId]);

            $participant->byPartId($part->Id);
        } else {
            $participant->byPartId(null);
        }

        $participant = $participant->find();
        if ($participant === null) {
            throw new Exception(304);
        }

        $this->getDetailLog()->addChangeMessage(new ChangeMessage('Role', $participant->RoleId, 0));
        if ($part !== null) {
            $this->getDetailLog()->addChangeMessage(new ChangeMessage('Day', $part->Id, $part->Id));
        }
        $this->getDetailLog()->UserId = $user->Id;
        $this->getDetailLog()->save();

        $participant->delete();
        
        echo json_encode(['Success' => true]);
    }
}
