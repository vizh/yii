<?php
namespace connect\models\forms;

use application\components\form\CreateUpdateForm;
use application\components\utility\Texts;
use connect\models\MeetingLinkUser;
use connect\models\Place;
use user\models\User;
use Yii;
use connect\models\Meeting as MeetingAR;

class Meeting extends CreateUpdateForm
{
    public $PlaceId;
    public $CreatorId;
    public $UserId;
    public $Date;
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
            ['PlaceId, CreatorId, Date, Type', 'required'],
            ['CreatorId', 'validateCreator'],
            ['UserId', 'validateUser', 'when' => function(){ return $this->Type == MeetingAR::TYPE_PRIVATE; }],
            ['Date', 'validateDate'],
            ['Purpose, Subject', 'filter', 'filter' => function($value){ return (new \CHtmlPurifier())->purify($value); }],
            ['File', 'file', 'maxSize' => 10*1024*1024, 'allowEmpty' => true]
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

    public function validateDate($attr, $params)
    {
        if (!\DateTime::createFromFormat('Y-m-d\TH:i:sP', $this->Date)){
            $this->addError('Date', 'Неверный формат даты '.$this->Date);
            return;
        }

        /** @var Place $place */
        $place = Place::model()->findByPk($this->PlaceId);
        if (!$place){
            return;
        }

        if ($place->Reservation && !$place->hasAvailableReservation($this->Date)){
            $this->addError('Date', 'На выбранное время нет доступных переговорных комнат');
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
            $date = new \DateTime($this->Date);
            $date->setTimezone(new \DateTimeZone(Yii::app()->timeZone));
            $this->model->Date = $date->format('Y-m-d H:i:s');

            $this->model->CreatorId = $this->Creator->Id;

            $this->model->Status = MeetingAR::STATUS_OPEN;

            if ($this->File){
                $filepath = $this->model->getFileDir();
                $filename = Texts::GenerateString(16).'.'.$this->File->extensionName;
                $this->File->saveAs($filepath.'/'.$filename);
                $this->model->File = $filename;
            }

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
                if ($this->Type == MeetingAR::TYPE_PRIVATE){
                    $link = new MeetingLinkUser();
                    $link->MeetingId = $this->model->Id;
                    $link->UserId = $this->User->Id;
                    $link->Status = MeetingLinkUser::STATUS_SENT;
                    $link->save(false);

                    $event = new \CEvent($this->model);
                    $event->params['user'] = $this->User;
                    $this->model->onInvite($event);
                }

                $transaction->commit();
                return true;
            }
            else{
                $transaction->rollback();
                return false;
            }
        }
        catch (\Exception $e){
            $transaction->rollback();
            throw $e;
        }
    }
}
