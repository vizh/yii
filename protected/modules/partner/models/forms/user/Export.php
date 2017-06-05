<?php
namespace partner\models\forms\user;

use application\components\form\EventItemCreateUpdateForm;
use event\models\Event;
use partner\models\Export as ExportModel;
use user\models\User;

class Export extends EventItemCreateUpdateForm
{
    /** @var User */
    private $user;

    public $Roles;
    public $Language = 'ru';
    public $Document;
    public $PartId;

    /**
     * @param Event $event
     * @param User $user
     */
    public function __construct(Event $event, User $user)
    {
        $this->user = $user;
        parent::__construct($event, null);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['model', 'validateHasRunningExports'],
            ['Language', 'required'],
            ['Document', 'boolean'],
            ['Roles', 'safe'],
            ['Language', 'in', 'range' => array_keys($this->getLanguageData())],
            ['PartId', 'in', 'range' => array_keys($this->getEventPartsData())]
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'Language' => \Yii::t('app', 'Язык выгрузки'),
            'Roles' => \Yii::t('app', 'Выберите роли для экспорта'),
            'PartId' => \Yii::t('app', 'Чать меропрития'),
            'Document' => \Yii::t('app', 'Добавить паспортные данные')
        ];
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function validateHasRunningExports($attribute)
    {
        if ($this->hasRunningExports()) {
            $this->addError($attribute, 'Выполняется, ранее запущенный, процесс экспорта, подождите его завершения.');
            return false;
        }
        return true;
    }

    /**
     * Создает запись в базе
     * @return ExportModel;
     * @throws Exception
     */
    public function createActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $this->model = new ExportModel();
        $this->model->EventId = $this->event->Id;
        $this->model->Config = json_encode($this->getAttributes());
        $this->model->UserId = $this->user->Id;
        $this->model->save();
        return $this->model;
    }

    /**
     * @return array
     */
    public static function getLanguageData()
    {
        return [
            'ru' => \Yii::t('app', 'Русский'),
            'en' => \Yii::t('app', 'English')
        ];
    }

    /**
     * @return array
     */
    public function getEventPartsData()
    {
        $data = ['' => \Yii::t('app', 'Все части')];
        foreach ($this->event->Parts as $part) {
            $data[$part->Id] = $part->Title;
        }
        return $data;
    }

    /**
     * Проверяет есть ли у мероприятия запущенные ранее экспорты
     * @return bool
     */
    public function hasRunningExports()
    {
        return ExportModel::model()->bySuccess(false)->byEventId($this->event->Id)->exists();
    }
}