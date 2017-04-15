<?php

namespace partner\models\search;

use application\components\form\SearchFormModel;
use event\models\Event;
use application\models\paperless\Material;

class PaperlessMaterial extends SearchFormModel
{
    /** @var Event */
    private $event;

    public $Name;
    public $activeLabel;

    public function __construct(Event $event)
    {
        $this->event = $event;
        parent::__construct();
    }

    public function rules()
    {
        return [
            ['Id, Name, activeLabel', 'safe']
        ];
    }

    public function getDataProvider()
    {
        $model = Material::model()->byEventId($this->event->Id);
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
            $criteria->addSearchCondition('"Name"', $this->Name, true, 'and', 'ilike');
            if ($this->activeLabel != ''){
                $criteria->addColumnCondition(['"Active"' => boolval($this->activeLabel)]);
            }
        }
        return $criteria;
    }
}