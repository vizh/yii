<?php

namespace partner\models\search;

use application\components\form\SearchFormModel;
use event\models\Event;
use application\models\paperless\Device;

class PaperlessDevice extends SearchFormModel
{
    /** @var Event */
    private $event;

    public $Id;
    public $DeviceNumber;
    public $Name;
    public $Type;
    public $activeLabel;

    public function __construct(Event $event)
    {
        $this->event = $event;
        parent::__construct();
    }

    public function rules()
    {
        return [
            ['Id,DeviceNumber,Name,Type,activeLabel', 'safe']
        ];
    }

    public function getDataProvider()
    {
        $model = Device::model()
            ->byEventId($this->event->Id);

        return new \CActiveDataProvider($model, [
            'criteria' => $this->getCriteria(),
            'sort' => false
        ]);
    }

    /**
     * @return \CDbCriteria
     */
    private function getCriteria()
    {
        $criteria = new \CDbCriteria();

        if ($this->validate()) {
            $criteria->compare('"Id"', $this->Id);
            $criteria->compare('"Type"', $this->Type);
            $criteria->addSearchCondition('"Name"', $this->Name, true, 'and', 'ilike');
            if ($this->activeLabel != ''){
                $criteria->addColumnCondition(['"Active"' => boolval($this->activeLabel)]);
            }
        }
        return $criteria;
    }
}