<?php
namespace application\components\form;

use event\models\Event;

class EventItemCreateUpdateForm extends CreateUpdateForm
{
    /** @var Event */
    protected $event;

    public function __construct(Event $event, \CActiveRecord $model = null)
    {
        $this->event = $event;
        parent::__construct($model);
    }
}
