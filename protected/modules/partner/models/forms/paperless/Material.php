<?php

namespace partner\models\forms\paperless;

use application\components\form\CreateUpdateForm;
use application\helpers\Flash;
use event\models\Event;
use paperless\models\Material as MaterialModel;
use paperless\models\MaterialLinkRole;

class Material extends CreateUpdateForm
{
    public $Id;
    public $Name;
    public $Comment;
    public $Active;
    public $Visible;
    public $File;
    public $Roles;
    public $PartnerName;
    public $PartnerSite;
    public $PartnerLogo;

    /** @var Event */
    protected $event;

    /**
     * @param Event $event
     * @param DeviceModel $model
     */
    public function __construct(Event $event, MaterialModel $model)
    {
        $this->event = $event;
        parent::__construct($model);
        $this->Roles = array_map(function ($link) {
            return $link->RoleId;
        }, $model->RoleLinks);
    }

    public function rules()
    {
        return [
            ['Name, Active', 'required'],
            ['Comment, Roles', 'safe'],
            ['PartnerName, PartnerSite', 'length', 'max' => 255],
            ['Active,Visible', 'boolean'],
            ['File, PartnerLogo', 'file', 'allowEmpty' => true],
        ];
    }

    public function attributeLabels()
    {
        return $this->model->attributeLabels();
    }

    /**
     * @return MaterialModel|null
     */
    public function createActiveRecord()
    {
        $this->model->EventId = $this->event->Id;
        return $this->updateActiveRecord();
    }

    /**
     * @return MaterialModel|null
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        try {
            $this->model->Name = $this->Name;
            $this->model->Comment = $this->Comment;
            $this->model->Active = $this->Active;
            $this->model->Visible = $this->Visible;
            $this->model->PartnerName = $this->PartnerName;
            $this->model->PartnerSite = $this->PartnerSite;

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

            if ($this->PartnerLogo) {
                $file = uniqid().'.'.$this->PartnerLogo->extensionName;
                $this->PartnerLogo->saveAs($this->model->getPartnerLogoPath() . '/' . $file);

                if ($this->model->PartnerLogo && is_file($this->model->getPartnerLogoPath() . '/' . $this->model->PartnerLogo)) {
                    unlink($this->model->getPartnerLogoPath() . '/' . $this->model->PartnerLogo);
                }

                $this->model->PartnerLogo = $file;
            }

            $this->model->save(false);

            $criteria = new \CDbCriteria();
            $criteria->addColumnCondition(['"MaterialId"' => $this->model->Id]);
            MaterialLinkRole::model()->deleteAll($criteria);

            if (false === empty($this->Roles)) {
                foreach ($this->Roles as $role) {
                    $link = new MaterialLinkRole();
                    $link->MaterialId = $this->model->Id;
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
        $this->PartnerLogo = \CUploadedFile::getInstance($this, 'PartnerLogo');
    }

    public function roles()
    {
        return $this->event->getRoles();
    }
}