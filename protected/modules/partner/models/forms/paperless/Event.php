<?php

namespace partner\models\forms\paperless;

use application\components\form\CreateUpdateForm;
use application\components\helpers\ArrayHelper;
use application\helpers\Flash;
use application\models\paperless\Device;
use application\models\paperless\Event as EventModel;
use application\models\paperless\EventLinkDevice;
use application\models\paperless\EventLinkMaterial;
use application\models\paperless\EventLinkRole;
use application\models\paperless\Material;

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
    public $Materials;

    /** @var Event */
    protected $event;

    /** @var array */
    protected $devices;

    /** @var array */
    protected $materials;

    /**
     * @param \event\models\Event $event
     * @param EventModel $model
     */
    public function __construct(\event\models\Event $event, EventModel $model)
    {
        $this->event = $event;
        $this->Roles = ArrayHelper::getColumn($model->RoleLinks, 'RoleId');
        $this->Devices = ArrayHelper::getColumn($model->DeviceLinks, 'DeviceId');
        $this->Materials = ArrayHelper::getColumn($model->MaterialLinks, 'MaterialId');
        parent::__construct($model);
    }

    public function rules()
    {
        return [
            ['Subject, Text', 'required'],
            ['SendOnce, ConditionLike, ConditionNotLike, Active', 'boolean'],
            ['ConditionLikeString, ConditionNotLikeString, Devices, Roles, Materials', 'safe'],
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

            EventLinkDevice::model()
                ->byEventId($this->model->Id)
                ->deleteAll();

            if (false === empty($this->Devices)) {
                foreach ($this->Devices as $device) {
                    $link = new EventLinkDevice();
                    $link->EventId = $this->model->Id;
                    $link->DeviceId = $device;
                    $link->save(false);
                }
            }

            EventLinkRole::model()
                ->byEventId($this->model->Id)
                ->deleteAll();

            if (false === empty($this->Roles)) {
                foreach ($this->Roles as $role) {
                    $link = new EventLinkRole();
                    $link->EventId = $this->model->Id;
                    $link->RoleId = $role;
                    $link->save(false);
                }
            }

            EventLinkMaterial::model()
                ->byEventId($this->model->Id)
                ->deleteAll();

            if (false === empty($this->Materials)) {
                foreach ($this->Materials as $material) {
                    $link = new EventLinkMaterial();
                    $link->EventId = $this->model->Id;
                    $link->MaterialId = $material;
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

    public function getMaterials()
    {
        if ($this->materials === null) {
            $this->materials = Material::model()
                ->byEventId($this->event->Id)
                ->findAll();
        }
        return $this->materials;
    }
}