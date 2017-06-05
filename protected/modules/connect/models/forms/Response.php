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
            [
                'Response',
                'filter',
                'filter' => function ($value) {
                    return (new \CHtmlPurifier())->purify($value);
                }
            ]
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

        $transaction = Yii::app()->db->beginTransaction();

        try {
            $this->fillActiveRecord();

            /** @var MeetingAR $meeting */
            $meeting = $this->model->Meeting;

            $saved = $this->model->save();

            if ($saved) {
                if ($this->model->Status == MeetingLinkUser::STATUS_ACCEPTED) {
                    $meeting->reserveMeetingRoom();

                    $event = new \CEvent($meeting);
                    $event->params['user'] = $this->model->User;
                    $meeting->onAccept($event);
                }
                if ($this->model->Status == MeetingLinkUser::STATUS_DECLINED
                    || $this->model->Status == MeetingLinkUser::STATUS_CANCELLED
                ) {
                    $event = new \CEvent($meeting);
                    $event->params['user'] = $this->model->User;
                    $event->params['response'] = $this->Response;
                    $meeting->onDeclineOrCancel($event);
                }
            }

            $transaction->commit();
            return $saved;
        } catch (\Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }
}
