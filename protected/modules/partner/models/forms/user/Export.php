<?php
namespace partner\models\forms\user;

use event\models\Event;
use partner\models\Export as ExportModel;

use application\components\form\EventItemCreateUpdateForm;
use user\models\User;

class Export extends EventItemCreateUpdateForm
{
    /** @var User */
    private $user;

    public $Roles;
    public $Language = 'ru';

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
            ['Roles', 'safe'],
            ['Language', 'in', 'range' => array_keys($this->getLanguageData())]
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'Language' => \Yii::t('app', 'Язык выгрузки'),
            'Roles' => \Yii::t('app', 'Выберите роли для экспорта')
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
    public function getLanguageData()
    {
        return [
            'ru' => \Yii::t('app', 'Русский'),
            'en' => \Yii::t('app', 'English')
        ];
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