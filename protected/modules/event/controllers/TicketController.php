<?php

use event\models\Event;
use event\models\Role;
use user\models\User;
use event\models\Participant;

class TicketController extends application\components\controllers\PublicMainController
{
    public function actionIndex($eventIdName, $runetId, $hash)
    {
        $event = Event::model()->byIdName($eventIdName)->find();
        $user = User::model()->byRunetId($runetId)->find();
        if (!$event || !$user || !$this->checkHash($event, $user, $hash)) {
            throw new \CHttpException(404);
        }

        // Custom check
        $this->checkAccess($event, $user);

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

    /**
     * Close access for some users
     * @param Event $event Current event
     * @param User $user Current user
     * @throws \CHttpException
     */
    private function checkAccess(Event $event, User $user)
    {
        // Close access for virtual participants of the rif16
        $participant = Participant::model()->byUserId($user->Id)->byEventId($event->Id)->find();
        #TODO: костыль для тикетов с mcf16
        if ($participant->RoleId == Role::VIRTUAL_ROLE_ID && $event->IdName !== 'mcf16') {
            throw new \CHttpException(404, 'Virtual participants of rif16 can\'t get the ticket');
        }

        if ($participant->RoleId == Role::VIRTUAL_ROLE_ID && $event->IdName !== 'rif17') {
            throw new \CHttpException(404, 'Virtual participants of rif17 can\'t get the ticket');
        }
    }
}
