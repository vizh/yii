<?php
namespace event\widgets;

use application\components\web\Widget;
use event\models\Event;
use event\models\Participant as ParticipantModel;
use event\models\Role;


/**
 * Виджет с иноформацией о статусе участия текущего пользователя на мероприятие
 *
 * Class Participant
 * @package event\widgets
 *
 */
class Participant extends Widget
{
    /** @var Event */
    public $event;

    /** @var Role[] */
    public $roles = [];

    public function run()
    {
        $participant = $this->getParticipant();
        if ($participant !== null) {
            $this->render('participant', ['participant' => $participant]);
        }
    }

    /**
     * @return ParticipantModel|null
     */
    private function getParticipant()
    {
        $user = \Yii::app()->getUser()->getCurrentUser();
        if (empty($user)) {
            return null;
        }

        $participant = ParticipantModel::model()
            ->with(['User', 'Role'])->byUserId($user->Id)->byEventId($this->event->Id)->find();

        if ($participant === null || !$this->checkRole($participant)) {
            return null;
        }
        return $participant;
    }

    /**
     * @param ParticipantModel $participant
     * @return bool
     */
    private function checkRole(ParticipantModel $participant)
    {
        if (!empty($this->roles)) {
            foreach ($this->roles as $role) {
                if ($participant->RoleId === $role->Id) {
                    return true;
                }
            }
        } elseif ($participant->RoleId !== Role::VIRTUAL_ROLE_ID) {
            return true;
        }
        return false;
    }
}