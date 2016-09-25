<?php
namespace connect\models\forms;

use application\components\form\CreateUpdateForm;
use application\components\utility\Texts;
use connect\models\MeetingLinkUser;
use connect\models\Place;
use connect\models\Reservation;
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
    public $Type;
    public $Purpose;
    public $Subject;
    /** @var \CUploadedFile $File */
    public $File;

    protected $Creator;
    protected $User;

    public function rules()
    {
        return [
            ['PlaceId, CreatorId, Date, Time, Type', 'required'],
            ['CreatorId', 'validateCreator'],
            ['UserId', 'validateUser', 'when' => function(){ return $this->Type == MeetingAR::TYPE_PRIVATE; }],
            ['Date', 'date', 'format' => 'yyyy-MM-dd'],
            ['Time', 'date', 'format' => 'HH:mm'],
            ['Time', 'validateTime'],
            ['Purpose, Subject', 'length', 'min' => 0, 'max' => 255],
            ['File', 'file', 'maxSize' => 10*1024*1024]
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

    public function validateTime($attr, $params)
    {
        /** @var Place $place */
        $place = Place::model()->findByPk($this->PlaceId);
        if (!$place){
            return;
        }

        if (!$place->hasAvailableReservation($this->Date.' '.$this->Time)){
            $this->addError('Time', 'На выбранное время нет доступных переговорных комнат');
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
        $this->File = \CUploadedFile::getInstanceByName('File');
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

            $filepath = $this->model->getFileDir();
            $filename = Texts::GenerateString(16).'.'.$this->File->extensionName;
            $this->File->saveAs($filepath.'/'.$filename);
            $this->model->File = $filename;

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
        $transaction = Yii::app()->db->beginTransaction();

        try{
            $this->model = new MeetingAR();
            $this->model->Type = MeetingAR::TYPE_PUBLIC;
            $this->model->CreateTime = date('Y-m-d H:i:s');
            $saved = $this->updateActiveRecord();

            if ($saved){
                if ($this->model->Place->Reservation){
                    $this->model->ReservationNumber = $this->model->Place->assignReservation($this->model->Date);
                    $this->model->save(false);
                }

                if ($saved && $this->Type == MeetingAR::TYPE_PRIVATE){
                    $link = new MeetingLinkUser();
                    $link->MeetingId = $this->model->Id;
                    $link->UserId = $this->User->Id;
                    $link->Status = MeetingLinkUser::STATUS_SENT;
                    $link->save();
                }
            }

            $transaction->commit();
        }
        catch (\Exception $e){
            $transaction->rollback();
            throw $e;
        }
    }
}
