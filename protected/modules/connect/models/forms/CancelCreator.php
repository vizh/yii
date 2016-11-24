<?php
namespace connect\models\forms;

use application\components\form\CreateUpdateForm;
use connect\models\Meeting as MeetingAR;
use Yii;

class CancelCreator extends CreateUpdateForm
{
    public $Status;
    public $Response;

    public function rules()
    {
        return [
            ['Status', 'in', 'range' => [MeetingAR::STATUS_CANCELLED]],
            ['Response', 'filter', 'filter' => function($value){ return (new \CHtmlPurifier())->purify($value); }]
        ];
    }

    /**
     * @return \CActiveRecord
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @inheritDoc
     */
    public function fillFromPost()
    {
        foreach ($this->getAttributes() as $name => $value) {
            $param = Yii::app()->getRequest()->getParam($name);
            if ($param !== null) {
                $this->$name = $param;
            }
        }
    }

    /**
     * Заполняет модель данными из формы
     * @return bool
     */
    protected function fillActiveRecord()
    {
        if (parent::fillActiveRecord()) {
            $this->model->Status = $this->Status;
            $this->model->CancelResponse = $this->Response;
            return true;
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $this->fillActiveRecord();
        $saved = $this->model->save();

        if ($saved && $this->model->Type == MeetingAR::TYPE_PRIVATE){
            $event = new \CEvent($this->model);
            $event->params['response'] = $this->Response;
            $this->model->onCancelCreator($event);
        }

        return $saved;
    }
}
