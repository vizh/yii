<?php
namespace mail\models\forms\admin;

use geo\models\City;
use geo\models\Country;
use geo\models\Region;

class Template extends \CFormModel
{
    const ByEvent   = 'Event';
    const ByEmail   = 'Email';
    const ByRunetId = 'RunetId';
    const ByGeo     = 'Geo';


    const TypePositive = 'positive';
    const TypeNegative = 'negative';

    public $Title;
    public $Subject;
    public $From = 'users@runet-id.com';
    public $FromName = '—RUNET—ID—';
    public $SendPassbook;
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

    private $mailer;

    /**
     * @param \mail\components\mailers\template\ITemplateMailer $mailer
     * @param string $scenario
     */
    public function __construct($mailer, $scenario = '')
    {
        parent::__construct($scenario);
        $this->mailer = $mailer;
    }


    public function attributeLabels()
    {
        return [
            'Title' => \Yii::t('app', 'Название рассылки'),
            'Subject' => \Yii::t('app', 'Тема письма'),
            'From' => \Yii::t('app', 'Отправитель письма'),
            'FromName' => \Yii::t('app', 'Имя отправителя письма'),
            'SendPassbook' => \Yii::t('app', 'Добавлять PassBook'),
            'SendUnsubscribe' => \Yii::t('app', 'Отправлять отписавшимся'),
            'Active' => \Yii::t('app', 'Рассылка по выбранным получателям'),
            'Test' => \Yii::t('app', 'Получатели тестовой рассылки'),
            'Body' => \Yii::t('app', 'Тело письма'),
            'SendInvisible' => \Yii::t('app', 'Отправлять скрытым пользователям'),
            'Layout' => \Yii::t('app', 'Шаблон'),
            'ShowUnsubscribeLink' => \Yii::t('app', 'Показывать ссылку на отписку'),
            'ShowFooter' => \Yii::t('app', 'Показывать футер')
        ];
    }


    public function rules()
    {
        return [
            ['Title, Subject, From, FromName, SendPassbook, SendUnsubscribe, Active, SendInvisible,ShowUnsubscribeLink,ShowFooter', 'required'],
            ['Test, TestUsers, Body, Layout', 'safe'],
            ['From', 'email'],
            ['Conditions', 'default', 'value' => []],
            ['Conditions', 'filter', 'filter' => [$this, 'filterConditions']],
            ['Test', 'filter', 'filter' => [$this, 'filterTest']]
        ];
    }

    public function filterTest($value)
    {
        if ($this->Test == 1)
        {
            $this->TestUsers = trim($this->TestUsers, ', ');
            if (empty($this->TestUsers))
            {
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
        foreach ($value as $key => $condition)
        {
            switch($condition['by'])
            {
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
     * @param $condition string[]
     */
    private function filterConditionByEvent($condition)
    {
        $event = \event\models\Event::model()->findByPk($condition['eventId']);
        if ($event == null)
        {
            $this->addError('Conditions', \Yii::t('app', 'Не найдена мероприятие с ID:{id}', ['{id}' => $condition['eventId']]));
        }
        if (empty($condition['roles']))
            $condition['roles'] = [];

        return $condition;
    }

    private function filterConditionByEmail($condition)
    {
        if (empty($condition['emails']))
        {
            $this->addError('Conditions', \Yii::t('app', 'Укажите адреса Email в фильтре.'));
        }
        else
        {
            $emails = explode(',', $condition['emails']);
            foreach ($emails as $email)
            {
                $user = \user\models\User::model()->byEmail($email)->find();
                if ($user == null)
                {
                    $this->addError('Conditions', \Yii::t('app', 'Не найден пользователь с Email:"{email}"', ['{email}' => $email]));
                }
            }
        }
        return $condition;
    }

    private function filterConditionByRunetId($condition)
    {
        if (empty($condition['runetIdList']))
        {
            $this->addError('Conditions', \Yii::t('app', 'Укажите список RUNET-ID в фильтре.'));
        }
        else
        {
            $runetIdList = explode(',', $condition['runetIdList']);
            foreach ($runetIdList as $runetId)
            {
                $user = \user\models\User::model()->byRunetId($runetId)->find();
                if ($user == null)
                {
                    $this->addError('Conditions', \Yii::t('app', 'Не найден пользователь с RUNET-ID:"{runetId}"', ['{runetId}' => $runetId]));
                }
            }
        }
        return $condition;
    }

    private function filterConditionByGeo($condition)
    {
        if (empty($condition['countryId']) || empty($condition['regionId']) || empty($condition['label'])) {
            $this->addError('Conditions', \Yii::t('app', 'Укажите региональную принадлежность.'));
        }
        else {
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
            '{Role.Title}' => '<?=$user->Participants[0]->Role->Title;?>'
        ];
    }

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
            '{UnsubscribeUrl}' => \Yii::t('app', 'Ссылка на отписаться')
        ];
    }

    public function getConditionData()
    {
        return [
            self::ByEvent => 'По мероприятию',
            self::ByEmail => 'По email',
            self::ByRunetId => 'По RUNET-ID',
            self::ByGeo => 'По региональному признаку'
        ];
    }

    public function getTypeData()
    {
        return [
            self::TypePositive => \Yii::t('app', 'Добавить'),
            self::TypeNegative => \Yii::t('app', 'Исключить')
        ];
    }

    public function getEventRolesData()
    {
        $data = [];
        $roles = \event\models\Role::model()->findAll(['order' => '"t"."Title"']);
        foreach ($roles as $role)
        {
            $data[] = ['label' => $role->Id.' - '.$role->Title, 'value' => $role->Id];
        }
        return $data;
    }

    public function getLayoutData()
    {
        return [
            \mail\Models\Layout::None => \Yii::t('app', 'Без шаблона'),
            \mail\Models\Layout::OneColumn => \Yii::t('app', 'Одноколоночный'),
            \mail\Models\Layout::TwoColumn => \Yii::t('app', 'Двухколоночный')
        ];
    }
} 