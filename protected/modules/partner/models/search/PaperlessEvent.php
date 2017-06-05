<?php

namespace partner\models\search;

use application\components\form\SearchFormModel;
use application\models\paperless\Event;

class PaperlessEvent extends SearchFormModel
{
    /** @var \event\models\Event */
    private $event;

    public $Id;
    public $Subject;
    public $activeLabel;

    public function __construct(\event\models\Event $event)
    {
        $this->event = $event;
        parent::__construct();
    }

    public function rules()
    {
        return [
            ['Id, Subject, activeLabel', 'safe']
        ];
    }

    public function getDataProvider()
    {
        $model = Event::model()->byEventId($this->event->Id);
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
            $criteria->addSearchCondition('"Subject"', $this->Subject, true, 'and', 'ilike');
            if ($this->activeLabel != '') {
                $criteria->addColumnCondition(['"Active"' => boolval($this->activeLabel)]);
            }
        }
        return $criteria;
    }
}