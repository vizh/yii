<?php
namespace partner\models\forms\user;

use application\components\form\EventItemCreateUpdateForm;
use application\components\helpers\ArrayHelper;
use event\models\Event;
use event\models\Participant;
use user\models\User;

class Edit extends EventItemCreateUpdateForm
{
    /** @var User */
    private $user;

    /**
     * @param Event $event
     * @param User $user
     */
    public function __construct(Event $event, User $user)
    {
        $this->user = $user;
        parent::__construct($event);
    }

    /**
     * @return string
     */
    public function getParticipantsJson()
    {
        $event = $this->event;
        $participants = Participant::model()->byEventId($event->Id)->byUserId($this->user->Id)->orderBy(['"t"."PartId"'])->findAll();
        return json_encode(
            ArrayHelper::toArray($participants, ['event\models\Participant' => ['Part' => function (Participant $participant) use ($event) {
                if (!empty($event->Parts)) {
                    return $participant->Part->Title;
                }
                return null;
            }, 'RoleId']]), JSON_UNESCAPED_UNICODE
        );
    }
}