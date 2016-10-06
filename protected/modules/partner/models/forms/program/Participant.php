<?php
namespace partner\models\forms\program;

use application\components\form\CreateUpdateForm;
use application\helpers\Flash;
use company\models\Company;
use event\models\Role as EventRole;
use event\models\section\LinkUser;
use event\models\section\Report;
use event\models\section\Role;
use event\models\section\Section;
use user\models\User;

class Participant extends CreateUpdateForm
{
    const EVENT_ROLE_ID = 3;
    const UNREGISTER_MESSAGE = 'Удален из секции в программе.';
    const REGISTER_MESSAGE = 'Добавлен в секцию в программе.';

    /** @var LinkUser */
    protected $model;

    /** @var Section */
    protected $section;

    public $RoleId;
    public $ReportTitle;
    public $ReportThesis;
    public $ReportUrl;
    public $ReportFullInfo;
    public $VideoUrl;
    public $Delete;
    public $Order;

    public $RunetId;
    public $CompanyId;
    public $CustomText;

    /**
     * @param Section $section
     * @param \CActiveRecord $model
     */
    public function __construct(Section $section, \CActiveRecord $model = null)
    {
        $this->section = $section;
        parent::__construct($model);
    }


    /**
     * @inheritdoc
     */
    protected function loadData()
    {
        if (parent::loadData()) {
            if (!empty($this->model->UserId)) {
                $this->RunetId = $this->model->User->RunetId;
            }

            if (!empty($this->model->Report)) {
                $this->ReportTitle = $this->model->Report->Title;
                $this->ReportThesis = $this->model->Report->Thesis;
                $this->ReportUrl = $this->model->Report->Url;
                $this->ReportFullInfo = $this->model->Report->FullInfo;
            }
            return true;
        }
    }


    public function rules()
    {
        return [
            ['ReportTitle', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            ['Order,RunetId,CompanyId', 'numerical', 'allowEmpty' => true],
            ['RunetId', 'validateUser'],
            ['RoleId', 'required'],
            ['RoleId', 'in', 'range' => array_keys($this->getRoleData())],
            ['Delete, VideoUrl', 'safe'],
            ['ReportUrl', 'url', 'allowEmpty' => true],
            ['ReportFullInfo,CustomText,ReportThesis', 'filter', 'filter' => [$this, 'filterHtmlText']]
        ];
    }

    /**
     * @param string $attribute
     * @return bool
     */
    public function validateUser($attribute)
    {
        if (!empty($this->RunetId)) {
            $exist = User::model()->byRunetId($this->RunetId)->exists();
            if (!$exist) {
                $this->addError('', \Yii::t('app', 'Не найден пользователь с RUNET-ID: {RunetId}', ['{RunetId}' => $this->RunetId]));
                return false;
            }
        } elseif (!empty($this->CompanyId)) {
            $exist = Company::model()->findByPk($this->CompanyId);
            if (!$exist) {
                $this->addError('', \Yii::t('app', 'Не найдена компания с ID: {CompanyId}', ['{CompanyId}' => $this->CompanyId]));
                return false;
            }
        } elseif (empty($this->CustomText)) {
            $this->addError('', 'Должно быть заполнено хотя бы одно из полей: Пользователь, Компания или Произвольный текст');
            return false;
        }
        return true;
    }

    /**
     * @param $value
     * @return string
     */
    public function filterHtmlText($value)
    {
        $purifier = new \CHtmlPurifier();
        $purifier->options = [
            'HTML.AllowedElements'     => ['p', 'span', 'ol', 'li', 'strong', 'a', 'em', 's', 'ul', 'br', 'u', 'table', 'tbody', 'tr', 'td', 'thead', 'th', 'caption', 'h1', 'h2', 'h3', 'h4', 'h5', 'img'],
            'HTML.AllowedAttributes'   => ['style', 'a.href', 'a.target', 'table.cellpadding', 'table.cellspacing', 'th.scope', 'table.border', 'img.alt', 'img.src'],
            'Attr.AllowedFrameTargets' => ['_blank', '_self']
        ];
        return $purifier->purify($value);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'RunetId' => \Yii::t('app', 'Пользователь'),
            'CompanyId' => \Yii::t('app', 'Компания'),
            'CustomText' => \Yii::t('app', 'Произвольный текст'),
            'ReportTitle' => \Yii::t('app', 'Название доклада'),
            'ReportThesis' => \Yii::t('app', 'Тезисы доклада'),
            'ReportFullInfo' => \Yii::t('app', 'Текст доклада'),
            'ReportUrl' => \Yii::t('app', 'Ссылка на доклад'),
            'Delete' => \Yii::t('app', 'Удалить'),
            'Order' => \Yii::t('app', 'Сортировка'),
            'RoleId' => \Yii::t('app', 'Роль'),
            'Report' => \Yii::t('app', 'Доклад'),
            'VideoUrl' => \Yii::t('app', 'Ссылка на видеозапись')
        ];
    }

    /**
     * @return array
     */
    public function getRoleData()
    {
        return \CHtml::listData(Role::model()->findAll(), 'Id', 'Title');
    }

    /**
     * @return string
     */
    public function getId()
    {
        return 'participant' . ($this->isUpdateMode() ? $this->model->Id : 'new');
    }

    /**
     * @return Section
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @return \CActiveRecord|null
     */
    public function createActiveRecord()
    {
        $this->model = new LinkUser();
        $this->model->SectionId = $this->section->Id;
        return $this->updateActiveRecord();
    }

    /**
     * @return \CActiveRecord|null
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            if ($this->Delete == 1) {
                $this->model->delete();
                $this->unRegisterUser();
            } else {
                $this->model->UserId = null;
                $this->model->CompanyId = null;
                $this->model->CustomText = null;

                if (!empty($this->RunetId)) {
                    $this->registerUser();
                } elseif (!empty($this->CompanyId)) {
                    $this->model->CompanyId = $this->CompanyId;
                } else {
                    $this->model->CustomText = $this->CustomText;
                }

                $this->model->RoleId = $this->RoleId;
                $this->model->Order = $this->Order;
                $this->model->VideoUrl = !empty($this->VideoUrl) ? $this->VideoUrl : null;
                if (!$this->getIsEmptyReportData()) {
                    $report = $this->model->Report !== null ? $this->model->Report : new Report();
                    $report->Url = !empty($this->ReportUrl) ? $this->ReportUrl : null;
                    $report->Thesis = !empty($this->ReportThesis) ? $this->ReportThesis : null;
                    $report->Title = !empty($this->ReportTitle) ? $this->ReportTitle : '';
                    $report->FullInfo = !empty($this->ReportFullInfo) ? $this->ReportFullInfo : null;
                    $report->save();
                    $this->model->ReportId = $report->Id;
                }
                $this->model->save();
            }
            $transaction->commit();
            return $this->model;
        } catch (\CDbException $e) {
            $transaction->rollBack();
            Flash::setError($e);
        }
    }

    /**
     * @return bool
     */
    private function getIsEmptyReportData()
    {
        return empty($this->ReportTitle) && empty($this->ReportThesis) && empty($this->ReportUrl) && empty($this->ReportFullInfo);
    }

    /**
     * Если в качестве участника указан пользователь, то регистрирует его на мероприятие
     */
    private function registerUser()
    {
        if (empty($this->RunetId)) {
            return;
        }

        $event = $this->section->Event;

        $user = User::model()->byRunetId($this->RunetId)->find();

        $this->model->UserId = $user->Id;

        // Если пользователь уже зарегистрирован на мероприятие, то ничего не делаем.
        if ($event->IdName === 'forinnovations16' && $event->hasParticipant($user)) {
            return;
        }


        $role = EventRole::model()->findByPk(self::EVENT_ROLE_ID);
        if (!empty($event->Parts)) {
            $event->registerUserOnAllParts($user, $role, true);
        } else {
            $event->registerUser($user, $role, true, self::REGISTER_MESSAGE);
        }
    }

    /**
     * Если в качестве участника указан пользователь, то снимает его регистрациб с мероприятия
     */
    private function unRegisterUser()
    {
        if (empty($this->RunetId)) {
            return;
        }
        $user = User::model()->byRunetId($this->RunetId)->find();
        $event = $this->section->Event;
        $existLink = LinkUser::model()->byEventId($event->Id)->byUserId($user->Id)->byDeleted(false)->exists();

        // Для Открытых инноваций не разрегистрируем спикеров при удалении из секции
        if ($event->IdName === 'forinnovations16') {
            return;
        }

        if (!$existLink) {
            $event->unregisterUser($user, self::UNREGISTER_MESSAGE);
        }
    }
}
