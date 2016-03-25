<?php
namespace event\models\forms;

use application\components\helpers\ArrayHelper;
use application\models\attribute\forms\Group;
use application\models\attribute\Group as GroupModel;
use event\models\Event;
use event\models\UserData;

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
     */
    protected function getUsedDefinitionNamesInternal()
    {
        $names = [];
        $data = UserData::model()->byEventId($this->event->Id)->findAll();
        foreach ($data as $item) {
            $data = json_decode($item->Attributes, true);
            if (!is_array($data)) {
                continue;
            }

            $names = array_merge($names, array_keys(json_decode($item->Attributes, true)));
        }

        return array_unique($names);
    }
}
