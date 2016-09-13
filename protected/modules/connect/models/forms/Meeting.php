<?php
namespace connect\models\forms;

use application\components\form\CreateUpdateForm;
use user\models\User;
use Yii;
use connect\models\Meeting as MeetingAR;

class Meeting extends CreateUpdateForm
{
    public $PlaceId;
    public $CreatorId;
    public $UserId;
    public $Date;
    public $Time;

    protected $Creator;
    protected $User;

    public function rules()
    {
        return [
            ['PlaceId, CreatorId, UserId, Date, Time', 'required'],
            ['CreatorId', 'validateCreator'],
            ['UserId', 'validateUser'],
            ['Date', 'date', 'format' => 'yyyy-MM-dd'],
            ['Time', 'date', 'format' => 'HH:mm'],
        ];
    }

    public function validateCreator($attr, $params)
    {
        $this->Creator = User::model()->findByAttributes(['RunetId' => $this->CreatorId]);
        if (!$this->Creator){
            $this->addError('CreatorId', 'Не найден пользователь с RUNET-ID: '.$this->CreatorId);
        }
    }

    public function validateUser($attr, $params)
    {
        $this->User = User::model()->findByAttributes(['RunetId' => $this->UserId]);
        if (!$this->User){
            $this->addError('UserId', 'Не найден пользователь с RUNET-ID: '.$this->UserId);
        }
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
            $this->model->Date = $this->Date.' '.$this->Time;
            $this->model->CreatorId = $this->Creator->Id;
            $this->model->UserId = $this->User->Id;
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
        return $this->model->save();
    }

    /**
     * @inheritDoc
     */
    public function createActiveRecord()
    {
        $this->model = new MeetingAR();
        $this->model->Status = MeetingAR::STATUS_SENT;
        return $this->updateActiveRecord();
    }
}
