<?php

namespace partner\models\forms\paperless;

use application\components\form\CreateUpdateForm;
use application\helpers\Flash;
use paperless\models\Device;
use paperless\models\Event as EventModel;
use paperless\models\EventLinkDevice;
use paperless\models\EventLinkRole;

class Event extends CreateUpdateForm
{
    public $Id;
    public $Subject;
    public $Text;
    public $SendOnce;
    public $ConditionLike;
    public $ConditionLikeString;
    public $ConditionNotLike;
    public $ConditionNotLikeString;
    public $Active;
    public $File;
    public $Roles;
    public $Devices;

    /** @var Event */
    protected $event;

    /** @var array */
    protected $devices;

    /**
     * @param \event\models\Event $event
     * @param EventModel $model
     */
    public function __construct(\event\models\Event $event, EventModel $model)
    {
        $this->event = $event;
        parent::__construct($model);
        $this->Roles = array_map(function ($link) {
            return $link->RoleId;
        }, $model->RoleLinks);
        $this->Devices = array_map(function ($link) {
            return $link->DeviceId;
        }, $model->DeviceLinks);
    }

    public function rules()
    {
        return [
            ['Subject, Text', 'required'],
            ['SendOnce, ConditionLike, ConditionNotLike, Active', 'boolean'],
            ['ConditionLikeString, ConditionNotLikeString, Devices, Roles', 'safe'],
            ['File', 'file', 'allowEmpty' => true],
        ];
    }

    public function attributeLabels()
    {
        return $this->model->attributeLabels();
    }

    /**
     * @return EventModel|null
     */
    public function createActiveRecord()
    {
        $this->model->EventId = $this->event->Id;
        return $this->updateActiveRecord();
    }

    /**
     * @return EventModel|null
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        try {
            $this->model->Subject = $this->Subject;
            $this->model->Text = $this->Text;
            $this->model->SendOnce = $this->SendOnce;
            $this->model->ConditionLike = $this->ConditionLike;
            $this->model->ConditionLikeString = $this->ConditionLikeString;
            $this->model->ConditionNotLike = $this->ConditionNotLike;
            $this->model->ConditionNotLikeString = $this->ConditionNotLikeString;
            $this->model->Active = $this->Active;

            if (!$this->model->validate()) {
                return null;
            }

            if ($this->File) {
                $file = uniqid().'.'.$this->File->extensionName;
                $this->File->saveAs($this->model->getFilePath() . '/' . $file);

                if ($this->model->File && is_file($this->model->getFilePath() . '/' . $this->model->File)) {
                    unlink($this->model->getFilePath() . '/' . $this->model->File);
                }

                $this->model->File = $file;
            }

            $this->model->save(false);

            $criteria = new \CDbCriteria();
            $criteria->addColumnCondition(['"EventId"' => $this->model->Id]);
            EventLinkDevice::model()->deleteAll($criteria);
            foreach ($this->Devices as $device) {
                $link = new EventLinkDevice();
                $link->EventId = $this->model->Id;
                $link->DeviceId = $device;
                $link->save(false);
            }

            $criteria = new \CDbCriteria();
            $criteria->addColumnCondition(['"EventId"' => $this->model->Id]);
            EventLinkRole::model()->deleteAll($criteria);
            if (false === empty($this->Roles)) {
                foreach ($this->Roles as $role) {
                    $link = new EventLinkRole();
                    $link->EventId = $this->model->Id;
                    $link->RoleId = $role;
                    $link->save(false);
                }
            }

            return $this->model;
        } catch (\CDbException $e) {
            Flash::setError($e);
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function fillFromPost()
    {
        parent::fillFromPost();
        $this->File = \CUploadedFile::getInstance($this, 'File');
    }

    public function getRoles()
    {
        return $this->event->getRoles();
    }

    public function getDevices()
    {
        if ($this->devices === null) {
            $this->devices = Device::model()
                ->byEventId($this->event->Id)
                ->findAll();
        }
        return $this->devices;
    }
}