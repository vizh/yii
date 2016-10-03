<?php
namespace connect\models\forms;

use application\components\form\CreateUpdateForm;
use connect\models\Meeting as MeetingAR;
use connect\models\MeetingLinkUser;
use Yii;

class Response extends CreateUpdateForm
{
    public $Status;
    public $Response;

    public function rules()
    {
        return [
            ['Status', 'in', 'range' => [MeetingLinkUser::STATUS_ACCEPTED, MeetingLinkUser::STATUS_DECLINED, MeetingLinkUser::STATUS_CANCELLED]],
            ['Response', 'length', 'min' => 0, 'max' => 255]
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

        /** @var MeetingAR $meeting */
        $meeting = $this->model->Meeting;

        $saved = $this->model->save();

        if ($saved){
            $meeting->reserveMeetingRoom();

            if ($this->model->Status == MeetingLinkUser::STATUS_ACCEPTED){
                $event = new \CEvent($meeting);
                $event->params['user'] = $this->model->User;
                $meeting->onAccept($event);
            }
            if ($this->model->Status == MeetingLinkUser::STATUS_DECLINED){
                $event = new \CEvent($meeting);
                $event->params['user'] = $this->model->User;
                $event->params['response'] = $this->Response;
                $meeting->onDecline($event);
            }
        }

        return $saved;
    }
}
