<?php
namespace partner\models\forms\user;


use application\components\utility\Paginator;
use event\models\Role;
use user\models\User;

class ParticipantSearch extends \CFormModel
{
    private $event;

    public $User;
    public $Role;
    public $Sort;
    public $Ruvents;
    public $Company;

    public function __construct(\event\models\Event $event, $scenario = '')
    {
        parent::__construct($scenario);
        $this->event = $event;
    }

    public function rules()
    {
        return [
            ['User, Role, Sort, Ruvents, Company', 'safe']
        ];
    }

    /**
     * @return \CDbCriteria
     */
    private function getCriteria()
    {
        $criteria = new \CDbCriteria();

        $criteria->addCondition('"Participants"."EventId" = :EventId');
        $criteria->params['EventId'] = $this->event->Id;
        $criteria->with = [
            'Participants' => [
                'together' => true,
                'select' => false,
            ],
            'Badges' =>  [
                'alias' => 'BadgesForCondition',
                'select' => false,
                'together' => true,
                'on' => '"BadgesForCondition"."EventId" = :EventId'
            ],
            'EmploymentsForCriteria' => [
                'together' => true,
                'select' => false,
                'with' => [
                    'Company' => ['select' => false]
                ]
            ]
        ];
        $criteria->group = '"t"."Id"';

        if ($this->User != '') {
            $this->User = trim($this->User);
            if (filter_var($this->User, FILTER_VALIDATE_EMAIL) !== false) {
                $criteria->addCondition('"t"."Email" = :Email');
                $criteria->params['Email'] = $this->User;
            }
            else {
                $criteria->mergeWith(\user\models\User::model()->bySearch($this->User, null, true, false)->getDbCriteria());
            }
        }

        if ($this->Role != '') {
            $criteria->addCondition('"Participants"."RoleId" = :RoleId');
            $criteria->params['RoleId'] = (int)$this->Role;
        }

        if (!empty($this->Company)) {
            $criteria->addCondition('"Company"."Name" ILIKE :Company AND "EmploymentsForCriteria"."Primary"');
            $criteria->params['Company'] = '%'.$this->Company.'%';
        }

        if (!empty($this->Ruvents)) {
            $criteria->addCondition('"BadgesForCondition"."EventId" = :EventId');
        }

        $this->fillCriteriaOrder($criteria);
        return $criteria;
    }

    /**
     * @param \CDbCriteria $criteria
     * @return \CDbCriteria
     */
    private function fillCriteriaOrder(\CDbCriteria $criteria)
    {
        $sortValues = $this->getSortValues();
        $this->Sort = trim($this->Sort);
        $this->Sort = isset($sortValues[$this->Sort]) ? $this->Sort : 'DateRegister_DESC';
        $sort = explode('_', $this->Sort);
        switch ($sort[0]) {
            case 'DateRegister':$criteria->order = '"max"("Participants"."CreationTime")';
                break;
            case 'LastName': $criteria->order = '"t"."LastName"';
                break;
            case 'Ruvents': $criteria->order = 'Min("BadgesForCondition"."CreationTime")';
                break;
        }
        $criteria->order .= ' ' . $sort[1];
    }

    /**
     * Возращает найденных пользователей и панигатор для них
     * @return \stdClass
     */
    public function getResult()
    {
        $result = new \stdClass();

        $criteria = $this->getCriteria();
        $result->paginator = new Paginator(User::model()->count($criteria), [], true);
        $result->paginator->perPage = \Yii::app()->params['PartnerUserPerPage'];
        $criteria->mergeWith($result->paginator->getCriteria());

        $users = User::model()->findAll($criteria);
        $result->users = \CHtml::listData($users, 'Id', null);

        $criteria = new \CDbCriteria();
        $criteria->with = [
            'Participants' => [
                'on' => '"Participants"."EventId" = :EventId',
                'params' => ['EventId' => $this->event->Id],
                'together' => true
            ],
            'Settings',
            'Employments',
            'LinkPhones',
            'Badges' => [
                'together' => false,
                'order' => '"Badges"."CreationTime" ASC',
                'with' => ['Operator'],
                'on' => '"Badges"."EventId" = :EventId',
                'params' => ['EventId' => $this->event->Id]
            ]
        ];
        $criteria->addInCondition('"t"."Id"', array_keys($result->users));
        $users = User::model()->findAll($criteria);
        /** @var User $user */
        foreach ($users as $user) {
            $result->users[$user->Id] = $user;
        }

        return $result;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'User' => \Yii::t('app', 'Поисковая строка'),
            'Role' => \Yii::t('app', 'Статус'),
            'Sort' => \Yii::t('app', 'Сортировка'),
            'Ruvents' => \Yii::t('app', 'Прошли регистрацию'),
            'Company' => \Yii::t('app', 'Компания')
        ];
    }

    public function getSortValues()
    {
        $values = [
            'DateRegister_DESC' => 'по дате регистрации &DownArrow;',
            'DateRegister_ASC' => 'по дате регистрации &UpArrow;',
            'LastName_DESC' => 'по ФИО участника &DownArrow;',
            'LastName_ASC' => 'по ФИО участника &UpArrow;'
        ];
        if (!empty($this->Ruvents))
        {
            $values['Ruvents_DESC'] = 'по дате прохода регистрации &DownArrow;';
            $values['Ruvents_ASC']  = 'по дате прохода регистрации &UpArrow;';
        }
        return $values;
    }

    public function getRoleData()
    {
        $data = [
            '' => 'Все зарегистрированные'
        ];
        $roles = Role::model()->byEventId(\Yii::app()->partner->getAccount()->EventId)->findAll();
        $data += \CHtml::listData($roles, 'Id', 'Title');
        return $data;
    }
}