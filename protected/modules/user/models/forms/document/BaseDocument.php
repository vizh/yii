<?php
namespace user\models\forms\document;

use application\components\form\CreateUpdateForm;
use application\helpers\Flash;
use user\models\Document;
use user\models\DocumentType;
use user\models\User;

abstract class BaseDocument extends CreateUpdateForm
{
    /** @var Document|null */
    protected $model = null;

    /** @var DocumentType */
    protected $documentType;

    /** @var  User */
    protected $user;

    /** @var boolean */
    protected $active = false;

    /**
     * @param DocumentType $documentType
     * @param User $user
     * @param \CActiveRecord $model
     */
    public function __construct(DocumentType $documentType, User $user, \CActiveRecord $model = null)
    {
        $this->documentType = $documentType;
        $this->user = $user;
        parent::__construct($model);
    }


    /**
     * Наименование документа
     * @return string
     */
    public function getTitle()
    {
        return $this->documentType->Title;
    }

    /**
     * Рендерит форму редактирования данных документа
     * @param \CController $controller
     */
    public function renderEditView(\CController $controller)
    {
        $name = get_class($this);
        $name = strtolower(substr($name, strrpos($name, '\\') + 1));
        $view  = 'user.views.edit.document.' . $name;
        $controller->renderPartial($view, ['form' => $this]);
    }

    /**
     * @inheritdoc
     */
    public function createActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $document = new Document();
        $document->UserId = $this->user->Id;
        $document->TypeId = $this->documentType->Id;
        $document->Attributes = json_encode($this->getAttributes(), JSON_UNESCAPED_UNICODE);
        $document->save();
        return $document;
    }

    /**
     * @inheritdoc
     */
    public function updateActiveRecord()
    {
        $this->model = $this->createActiveRecord();
        return $this->model;
    }

    /**
     * @inheritdoc
     */
    protected function loadData()
    {
        if (!$this->isUpdateMode()) {
            return false;
        }

        $attributes = json_decode($this->model->Attributes);
        foreach ($attributes as $name => $value) {
            if (property_exists($this, $name)) {
                $this->$name = $value;
            }
        }
        return true;
    }

    /**
     * @return DocumentType
     */
    public function getDocumentType()
    {
        return $this->documentType;
    }

    /**
     * Активирует форму
     */
    public function activate()
    {
        $this->active = true;
    }

    /**
     * Возвращает активность формы
     */
    public function isActive()
    {
        return $this->active;
    }
} 