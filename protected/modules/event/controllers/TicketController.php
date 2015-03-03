<?php

use event\models\Event;
use user\models\User;
use event\models\Participant;

class TicketController extends application\components\controllers\PublicMainController
{
    public function actionIndex($eventIdName, $runetId, $hash)
    {
        $event = Event::model()->byIdName($eventIdName)->find();
        $user = User::model()->byRunetId($runetId)->find();
        if ($event == null || $user == null || !$this->checkHash($event, $user, $hash))
            throw new \CHttpException(404);


        $class = \Yii::getExistClass('event\components\tickets', ucfirst($event->IdName), 'Ticket');
        /** @var \event\components\tickets\Ticket $ticket */
        $ticket = new $class($event, $user);
        $ticket->getPdf()->Output($ticket->getFileName(), 'I');
    }

    /**
     * @param User $user
     * @param Event $event
     * @param string $hash
     * @return bool
     */
    private function checkHash(Event $event, User $user, $hash) {
        $model = Participant::model()->byUserId($user->Id)->byEventId($event->Id);
        if (!empty($event->Parts)) {
            $model->with('Part');
        }
        $participants = $model->findAll();
        foreach ($participants as $participant) {
            if ($participant->getHash() == $hash)
                return true;
        }
        return false;
    }
}
