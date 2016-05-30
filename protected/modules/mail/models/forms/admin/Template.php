<?php
namespace mail\models\forms\admin;

use application\components\form\CreateUpdateForm;
use event\models\Role;
use event\models\Event;
use geo\models\City;
use geo\models\Country;
use geo\models\Region;
use mail\components\filter\EmailCondition;
use mail\components\filter\EventCondition;
use mail\components\filter\GeoCondition;
use mail\components\filter\RunetIdCondition;
use mail\models\Layout;
use mail\models\TemplateLog;
use user\models\User;
use mail\models\Template as TemplateModel;
use mail\components\filter\Main as MainFilter;

/**
 * Class Template
 *
 * @method TemplateModel getActiveRecord()
 */
class Template extends CreateUpdateForm
{
    const ByEvent      = 'Event';
    const ByEmail      = 'Email';
    const ByRunetId    = 'RunetId';
    const ByGeo        = 'Geo';

    const TypePositive = 'positive';
    const TypeNegative = 'negative';

    /** @var TemplateModel  */
    protected $model;

    public $Title;
    public $Subject;
    public $From = 'users@runet-id.com';
    public $FromName = '—RUNET—ID—';
    public $SendPassbook = 0;
    public $SendUnsubscribe;
    public $SendInvisible = 0;
    public $Active = 0;
    public $Test;
    public $TestUsers;
    public $Conditions = [];
    public $Body;
    public $Layout = \mail\models\Layout::OneColumn;
    public $ShowUnsubscribeLink = 1;
    public $ShowFooter = 1;
    public $RelatedEventId;

    /** @var \CUploadedFile[] */
    public $Attachments = [];

    public $SendUnverified = 0;

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'Title' => \Yii::t('app', 'Название рассылки'),
            'Subject' => \Yii::t('app', 'Тема письма'),
            'From' => \Yii::t('app', 'Отправитель письма'),
            'FromName' => \Yii::t('app', 'Имя отправителя письма'),
            'SendPassbook' => \Yii::t('app', 'Добавлять PassBook'),
            'SendUnsubscribe' => \Yii::t('app', 'Отправлять отписавшимся'),
            'SendUnverified' => \Yii::t('app', 'Отправлять неподтвежденным пользователям'),
            'Active' => \Yii::t('app', 'Рассылка по выбранным получателям'),
            'Test' => \Yii::t('app', 'Получатели тестовой рассылки'),
            'Body' => \Yii::t('app', 'Тело письма'),
            'SendInvisible' => \Yii::t('app', 'Отправлять скрытым пользователям'),
            'Layout' => \Yii::t('app', 'Шаблон'),
            'ShowUnsubscribeLink' => \Yii::t('app', 'Показывать ссылку на отписку'),
            'ShowFooter' => \Yii::t('app', 'Показывать футер'),
            'RelatedEventId' => \Yii::t('app', 'Связанное мероприятие'),
            'Attachments' => \Yii::t('app', 'Приложенные файлы')
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['Title, Subject, From, FromName, SendPassbook, SendUnsubscribe, Active, SendInvisible, ShowUnsubscribeLink, ShowFooter, SendUnverified', 'required'],
            ['Test, TestUsers, Body, Layout', 'safe'],
            ['From', 'email'],
            ['RelatedEventId', 'numerical', 'integerOnly' => true],
            ['RelatedEventId', 'exist', 'className' => '\event\models\Event', 'attributeName' => 'Id', 'skipOnError' => true],
            ['Conditions', 'default', 'value' => []],
            ['Conditions', 'filter', 'filter' => [$this, 'filterConditions']],
            ['Test', 'filter', 'filter' => [$this, 'filterTest']],
            ['Attachments', 'safe']
        ];
    }

    /**
     * @param $value
     * @return mixed
     */
    public function filterTest($value)
    {
        if ($this->Test == 1){
            $this->TestUsers = trim($this->TestUsers, ', ');
            if (empty($this->TestUsers)){
                $this->addError('Test', \Yii::t('app', 'Не указаны получатели тестовой рассылки.'));
            }
        }
        return $value;
    }

    /**
     * @param $value string
     * @return string
     */
    public function filterConditions($value)
    {
        $countByEvent = 0;
        foreach ($value as $key => $condition){
            switch($condition['by']){
                case self::ByEvent:
                    $value[$key] = $this->filterConditionByEvent($condition);
                    $countByEvent++;
                    break;

                case self::ByEmail:
                    $value[$key] = $this->filterConditionByEmail($condition);
                    break;

                case self::ByRunetId:
                    $value[$key] = $this->filterConditionByRunetId($condition);
                    break;

                case self::ByGeo:
                    $value[$key] = $this->filterConditionByGeo($condition);
                    break;
            }
        }

        if ((preg_match('/{Event.Title}|{TicketUrl}|{Role.Title}/', $this->Body) !== 0 || $this->SendPassbook == 1)
            && $countByEvent !== 1)
        {
            $this->addError('Conditions', \Yii::t('app', 'Для данных настроек, фильтр рассылки должен иметь только одно мероприятие!'));
        }
        return $value;
    }

    /**
     * @param string[] $condition
     * @return string
     */
    private function filterConditionByEvent($condition)
    {
        $event = Event::model()->findByPk($condition['eventId']);
        if ($event == null){
            $this->addError('Conditions', \Yii::t('app', 'Не найдена мероприятие с ID:{id}', ['{id}' => $condition['eventId']]));
        }
        if (empty($condition['roles']))
            $condition['roles'] = [];

        return $condition;
    }

    /**
     * @param $condition
     * @return mixed
     */
    private function filterConditionByEmail($condition)
    {
        if (empty($condition['emails'])){
            $this->addError('Conditions', \Yii::t('app', 'Укажите адреса Email в фильтре.'));
        } else {
            $emails = explode(',', $condition['emails']);
            foreach ($emails as $email){
                $user = User::model()->byEmail($email)->find();
                if ($user == null){
                    $this->addError('Conditions', \Yii::t('app', 'Не найден пользователь с Email:"{email}"', ['{email}' => $email]));
                }
            }
        }
        return $condition;
    }

    /**
     * @param $condition
     * @return mixed
     */
    private function filterConditionByRunetId($condition)
    {
        if (empty($condition['runetIdList'])){
            $this->addError('Conditions', \Yii::t('app', 'Укажите список RUNET-ID в фильтре.'));
        } else {
            $runetIdList = explode(',', $condition['runetIdList']);
            foreach ($runetIdList as $runetId) {
                $user = User::model()->byRunetId($runetId)->find();
                if ($user == null) {
                    $this->addError('Conditions', \Yii::t('app', 'Не найден пользователь с RUNET-ID:"{runetId}"', ['{runetId}' => $runetId]));
                }
            }
        }
        return $condition;
    }

    /**
     * @param $condition
     * @return mixed
     */
    private function filterConditionByGeo($condition)
    {
        if (empty($condition['countryId']) || empty($condition['regionId']) || empty($condition['label'])) {
            $this->addError('Conditions', \Yii::t('app', 'Укажите региональную принадлежность.'));
        } else {
            $country = Country::model()->findByPk($condition['countryId']);
            if ($country !== null) {
                $region = Region::model()->byCountryId($country->Id)->findByPk($condition['regionId']);
                if ($region !== null) {
                    if (!empty($condition['cityId'])) {
                        $city = City::model()->byCountryId($country->Id)->byRegionId($region->Id)->findByPk($condition['cityId']);
                        if ($city == null) {
                            $this->addError('Conditions', \Yii::t('app', 'Не найден город.'));
                        }
                    }
                } else {
                    $this->addError('Conditions', \Yii::t('app', 'Не найден регион.'));
                }
            } else {
                $this->addError('Conditions', \Yii::t('app', 'Не найдена страна.'));
            }
        }
        return $condition;
    }

    /**
     * @return array
     */
    public function bodyFields()
    {
        return [
            '{User.Url}' => '<?=$user->getUrl();?>',
            '{User.FullName}' => '<?=$user->getFullName();?>',
            '{User.ShortName}' => '<?=$user->getShortName();?>',
            '{User.RunetId}' => '<?=$user->RunetId;?>',
            '{UnsubscribeUrl}' => '<?=$user->getFastauthUrl(\'/user/setting/subscription/\');?>',
            '{Event.Title}' => '<?=$user->Participants[0]->Event->Title;?>',
            '{TicketUrl}' => '<?=$user->Participants[0]->getTicketUrl();?>',
            '{Role.Title}' => '<?=$user->Participants[0]->Role->Title;?>',
            '{Event.Start.Date}' => '<?=$event->getFormattedStartDate();?>',
            '{Event.End.Date}' => '<?=$event->getFormattedEndDate();?>'
        ];
    }

    /**
     * @return array
     */
    public function bodyFieldLabels()
    {
        return [
            '{User.Url}'       => \Yii::t('app', 'Ссылка на страницу пользователя'),
            '{User.FullName}'  => \Yii::t('app', 'Полное имя пользователя'),
            '{User.ShortName}' => \Yii::t('app', 'Краткое имя пользователя. Имя или имя + отчество'),
            '{User.RunetId}'   => \Yii::t('app', 'RUNET-ID пользователя'),
            '{Event.Title}'    => \Yii::t('app', 'Название меропрития'),
            '{TicketUrl}'      => \Yii::t('app', 'Ссылка на пригласительный'),
            '{Role.Title}'     => \Yii::t('app', 'Роль на меропритие'),
            '{UnsubscribeUrl}' => \Yii::t('app', 'Ссылка на отписаться'),
            '{Event.Start.Date}' => \Yii::t('app', 'Дата начала события'),
            '{Event.End.Date}' => \Yii::t('app', 'Дата окончания события'),
        ];
    }

    /**
     * @return array
     */
    public function getConditionData()
    {
        return [
            self::ByEvent => 'По мероприятию',
            self::ByEmail => 'По email',
            self::ByRunetId => 'По RUNET-ID',
            self::ByGeo => 'По региональному признаку'
        ];
    }

    /**
     * @return array
     */
    public function getTypeData()
    {
        return [
            self::TypePositive => \Yii::t('app', 'Добавить'),
            self::TypeNegative => \Yii::t('app', 'Исключить')
        ];
    }

    /**
     * @return array
     */
    public function getEventRolesData()
    {
        $data = [];
        $roles = Role::model()->findAll(['order' => '"t"."Title"']);
        foreach ($roles as $role) {
            $data[] = ['label' => $role->Id.' - '.$role->Title, 'value' => $role->Id];
        }
        return $data;
    }

    /**
     * @return array
     */
    public function getLayoutData()
    {
        return [
            Layout::None => \Yii::t('app', 'Без шаблона'),
            Layout::OneColumn => \Yii::t('app', 'Одноколоночный'),
            Layout::TwoColumn => \Yii::t('app', 'Двухколоночный'),
            Layout::DevCon16 => \Yii::t('app', 'DevCon 2016')
        ];
    }

    /**
     * @inheritdoc
     */
    public function createActiveRecord()
    {
        $this->model = new TemplateModel();
        return $this->updateActiveRecord();
    }


    /**
     * @inheritdoc
     */
    public function updateActiveRecord()
    {
        if ($this->model->Active || !$this->validate()) {
            return null;
        }
        $isNewRecord = $this->model->getIsNewRecord();

        $this->model->Title = $this->Title;
        $this->model->Subject = $this->Subject;
        $this->model->From = $this->From;
        $this->model->FromName = $this->FromName;
        $this->model->SendPassbook = $this->SendPassbook == 1 ? true : false;
        $this->model->SendUnsubscribe = $this->SendUnsubscribe == 1 ? true : false;
        $this->model->SendInvisible = $this->SendInvisible == 1 ? true : false;
        $this->model->SendUnverified = $this->SendUnverified == 1 ? true : false;
        $this->model->Active = $this->Active == 1 ? true : false;
        $this->model->Layout = $this->Layout;
        $this->model->ShowUnsubscribeLink = $this->ShowUnsubscribeLink == 1 ? true : false;
        $this->model->ShowFooter = $this->ShowFooter == 1 ? true : false;
        $this->model->RelatedEventId = !empty($this->RelatedEventId) ? $this->RelatedEventId : null;
        if ($this->model->Active){
            $this->model->ActivateTime = date('Y-m-d H:i:s');
        }

        $filter = new MainFilter();
        foreach ($this->Conditions as $key => $condition) {
            $positive = $condition['type'] == self::TypePositive ? true : false;
            switch ($condition['by']) {
                case self::ByEvent:
                    $condition = new EventCondition($condition['eventId'], $condition['roles']);
                    $filter->addCondition('\mail\components\filter\Event', $condition, $positive);
                    break;

                case self::ByEmail:
                    $condition = new EmailCondition(explode(',', $condition['emails']));
                    $filter->addCondition('\mail\components\filter\Email', $condition, $positive);
                    break;

                case self::ByRunetId:
                    $condition = new RunetIdCondition(explode(',', $condition['runetIdList']));
                    $filter->addCondition('\mail\components\filter\RunetId', $condition, $positive);
                    break;

                case self::ByGeo:
                    $condition = new GeoCondition($condition['label'], $condition['countryId'], $condition['regionId'], $condition['cityId']);
                    $filter->addCondition('\mail\components\filter\Geo', $condition, $positive);
                    break;
            }
        }
        $this->model->setFilter($filter);
        $this->model->save();

        if ($isNewRecord || !$this->model->checkViewExternalChanges()) {
            $this->saveView();
        }

        $this->saveAttachments();
        $this->model->save();
        if ($this->Test && !$this->sendTestMails()) {
            return null;
        }
        return $this->model;
    }

    /**
     * @inheritdoc
     */
    public function fillFromPost()
    {
        parent::fillFromPost();
        $this->Attachments = \CUploadedFile::getInstances($this, 'Attachments');
    }

    /**
     * Сохраняет приложенные к рассылки файлы
     */
    private function saveAttachments()
    {
        if (!empty($this->Attachments)) {
            $path = $this->getPathAttachments();
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            foreach ($this->Attachments as $i => $file) {
                $file->saveAs($path . DIRECTORY_SEPARATOR . str_replace(' ', '-', $file->name));
            };
        }
    }

    /**
     * @return string
     */
    public function getPathAttachments()
    {
        return \Yii::getpathOfAlias('webroot.files.upload.mails.template' . $this->model->Id);
    }

    /**
     * Сохраняет отображение рассылки
     */
    private function saveView()
    {
        $this->Body = strtr($this->Body, $this->bodyFields());
        file_put_contents($this->model->getViewPath(), $this->Body);
        $this->model->ViewHash = md5_file($this->model->getViewPath());
    }

    /**
     * @inheritdoc
     */
    protected function loadData()
    {
        if (parent::loadData()) {
            if (!$this->model->checkViewExternalChanges()){
                $this->Body = strtr(
                    file_get_contents($this->model->getViewPath()),
                    array_flip($this->bodyFields())
                );
            }
            $this->fillConditionsAttribute();

        }
        return false;
    }

    /**
     *
     */
    private function fillConditionsAttribute()
    {
        $filter = $this->model->getFilter()->getFilters();
        $filterMap = [
            '\mail\components\filter\Event'   => self::ByEvent,
            '\mail\components\filter\Email'   => self::ByEmail,
            '\mail\components\filter\RunetId' => self::ByRunetId,
            '\mail\components\filter\Geo'     => self::ByGeo
        ];

        $filters = [];
        foreach (array_keys($filter) as $class) {
            $filters[$class] = $filterMap[$class];
        }
        $conditions = [];
        $types = [
            self::TypePositive,
            self::TypeNegative
        ];
        foreach ($filters as $className => $by){
            foreach ($types as $type){
                if (isset($filter[$className])){
                    foreach ($filter[$className]->$type as $criteria){
                        $condition = ['type' => $type, 'by' => $by];
                        $class = new \ReflectionClass($criteria);
                        foreach ($class->getProperties() as $property){
                            $condition[$property->getName()] = isset($criteria->{$property->getName()}) ? $criteria->{$property->getName()} : null;
                        }

                        switch ($by){
                            case self::ByEvent:
                                $event = \event\models\Event::model()->findByPk($condition['eventId']);
                                $condition['eventLabel'] = $event->Id.', '.$event->Title;
                                break;

                            case self::ByEmail:
                                $condition['emails'] = implode(',', $condition['emails']);
                                break;

                            case self::ByRunetId:
                                $condition['runetIdList'] = implode(',', $condition['runetIdList']);
                                break;
                        }
                        $conditions[] = $condition;
                    }
                }
            }
        }
        $this->Conditions = $conditions;
    }

    /**
     * Кол-во пользовтелей, которые получат рассылку
     * @return int|string
     */
    public function getRecipientsCount()
    {
        if (!empty($this->model)) {
            return User::model()->count($this->model->getCriteria(true));
        }
        return 0;
    }

    /**
     * Кол-во уже отправленные писем
     * @return int|string
     */
    public function getSentCount()
    {
        if (!empty($this->model)) {
            return TemplateLog::model()->byTemplateId($this->model->Id)->byHasError(false)->count();
        }
        return 0;
    }

    /**
     * Отправка тестовых писем пользователю
     * @return bool
     */
    public function sendTestMails()
    {
        $this->model->setTestMode(true);
        $users = User::model()->byRunetIdList(explode(', ', $this->TestUsers))->findAll();
        foreach ($users as $user) {
            $criteria = $this->model->getCriteria();
            $criteria->addCondition('"t"."Id" = :UserId');
            $criteria->params['UserId'] = $user->Id;
            if (!User::model()->exists($criteria)) {
                $this->addError('Test', \Yii::t('app', 'В тестовой рассылке пользователь с RUNET-ID: {id} не попадает в общую выборку!', ['{id}' => $user->RunetId]));
                return false;
            }
        }

        $this->model->setTestUsers($users);
        $this->model->send();
        return true;
    }
} 