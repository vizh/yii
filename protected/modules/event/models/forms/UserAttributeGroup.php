<?php
namespace event\models\forms;

use application\models\attribute\forms\Group;
use application\models\attribute\Group as GroupModel;
use event\models\Event;
use Yii;

/**
 * Class UserAttributeGroup
 * @package event\models\forms
 *
 * @property GroupModel $model;
 */
class UserAttributeGroup extends Group
{
    /** @var Event */
    private $event;

    /**
     * @param Event $event
     * @param GroupModel $model
     */
    public function __construct(Event $event, GroupModel $model = null)
    {
        $this->event = $event;
        parent::__construct($model);
    }

    /**
     * Заполняет модель данными из формы
     * @return bool
     */
    protected function fillActiveRecord()
    {
        $this->model->ModelName = 'EventUserData';
        $this->model->ModelId = $this->event->Id;
        return parent::fillActiveRecord();
    }

    /**
     * @return array
     * @throws \CException
     */
    protected function getUsedDefinitionNamesInternal()
    {
        return Yii::app()->getDb()->createCommand()
            ->select('DISTINCT json_object_keys("Attributes")')
            ->from('EventUserData')
            ->where('"EventId" = :EventId AND json_typeof("Attributes") ~~ \'object\'', ['EventId' => $this->event->Id])
            ->queryColumn();
    }
}
