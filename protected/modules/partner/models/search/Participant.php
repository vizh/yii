<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 28.05.2015
 * Time: 17:06
 */

namespace application\modules\partner\models\search;


use application\components\form\SearchFormModel;
use application\components\helpers\ArrayHelper;
use application\components\web\ActiveDataProvider;
use event\models\Role;
use user\models\User;
use event\models\Event;
use Yii;

class Participant extends SearchFormModel
{
    /** @var Event */
    private $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
        parent::__construct('');
    }

    public $Query;

    public $Role;

    public $Company;

    public $Ruvents;

    public $Document;

    public function rules()
    {
        return [
            ['Query,Company', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            ['Role', 'type', 'type' => 'array'],
            ['Document', 'boolean']
        ];
    }

    public function attributeLabels()
    {
        return [
            'Name' => 'ФИО или E-mail',
            'Role' => 'Статус',
            'Company' => 'Работа',
            'Ruvents' => 'Регистрация',
            'Document' => 'Документ'
        ];
    }


    /**
     * @return \CDataProvider
     */
    public function getDataProvider()
    {
        $sort = $this->getSort();
        $criteria = new \CDbCriteria();
        $criteria->with = [
            'Participants' => [
                'on' => '"Participants"."EventId" = :EventId',
                'params' => ['EventId' => $this->event->Id],
                'together' => false
            ],
            'ParticipantsForCriteria' => [
                'together' => true,
                'select' => false,
                'on' => '"ParticipantsForCriteria"."EventId" = :EventId',
                'params' => ['EventId' => $this->event->Id],
            ],
            'Badges' => [
                'together' => false,
                'order' => '"Badges"."CreationTime" ASC',
                'with' => ['Operator'],
                'on' => '"Badges"."EventId" = :EventId',
                'params' => [
                    'EventId' => $this->event->Id
                ]
            ],
            'Documents'
        ];

        $criteria->addInCondition('"t"."Id"', \CHtml::listData(User::model()->findAll($this->getCriteria()), 'Id', 'Id'));

        if (array_key_exists('Ruvents', $sort->getDirections())) {
            $criteria->with['Badges']['together'] = true;
            $criteria->with['Badges']['on'] = '"Badges"."Id" IN (
                SELECT MIN("Id") FROM "RuventsBadge"
                WHERE "EventId" = :EventId
                GROUP BY "UserId"
            )';
        } elseif (array_key_exists('Role', $sort->getDirections())) {
            $criteria->group = '"t"."Id","ParticipantsForCriteria"."Id"';
        }

        return new \CActiveDataProvider('\user\models\User', [
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
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
                'select' => false
            ],
            'Documents' => [
                'together' => true,
                'select' => false
            ],
            'EmploymentsForCriteria' => [
                'together' => true,
                'select' => false,
                'with' => [
                    'Company' => ['select' => false]
                ]
            ]
        ];

        if ($this->validate()) {
            if ($this->Query != '') {
                $this->Query = trim($this->Query);
                if (filter_var($this->Query, FILTER_VALIDATE_EMAIL) !== false) {
                    $criteria->addCondition('"t"."Email" = :Email');
                    $criteria->params['Email'] = $this->Query;
                } else {
                    $model = User::model()->bySearch($this->Query, null, true, false);
                    if (strstr($this->Query, ' ') === false) {
                        $model->bySearchFirstName($this->Query, false);
                    }
                    $criteria->mergeWith($model->getDbCriteria());
                }
            }

            //ограничить выбор ролей доступными аккаунту
            $role = Yii::app()->partnerAuthManager->roles[Yii::app()->partner->role];
            $available_roles = ArrayHelper::getValue($role->data, 'roles', []);

            if (empty($available_roles)) {
                if (!empty($this->Role)) {
                    $criteria->addInCondition('"Participants"."RoleId"', $this->Role);
                }
            } else {
                if ($this->Role){
                    $roles = array_intersect($this->Role, $available_roles);
                }
                else{
                    $roles = $available_roles;
                }
                if (!empty($roles)){
                    $criteria->addInCondition('"Participants"."RoleId"', $roles);
                }
            }

            if (!empty($this->Company)) {
                $criteria->addCondition('"Company"."Name" ILIKE :Company AND "EmploymentsForCriteria"."Primary"');
                $criteria->params['Company'] = '%' . $this->Company . '%';
            }

            if ($this->Document != '') {
                $criteria->addCondition('"Documents"."Id" IS ' . ($this->Document ? 'NOT' : '')  . ' NULL');
            }
        }

        return $criteria;
    }

    public function getSort()
    {
        $sort = new \CSort();
        $sort->defaultOrder = ['Role' => SORT_DESC];
        $sort->attributes = [
            'Query' => 't.RunetId',
            'Name'  => [
                'asc'  => '"t"."LastName" ASC, "t"."FirstName" ASC',
                'desc' => '"t"."LastName" DESC, "t"."FirstName" DESC',
            ],
            'Role' => [
                'asc'  => 'max("ParticipantsForCriteria"."CreationTime") ASC',
                'desc' => 'max("ParticipantsForCriteria"."CreationTime") DESC'
            ],
            'Ruvents' => [
                'asc'  => '"Badges"."CreationTime" ASC nulls last',
                'desc' => '"Badges"."CreationTime" DESC nulls last'
            ]
        ];
        return $sort;

    }

    /**
     * @return array
     */
    public function getRoleData()
    {
        if (Yii::app()->partner->role === 'AdminExtended') {
            return \CHtml::listData($this->event->getRoles(), 'Id', 'Title');
        }

        $all_roles = ArrayHelper::map($this->event->getRoles(), 'Id', 'Title');

        //ограничить выбор ролей доступными аккаунту
        $role = Yii::app()->partnerAuthManager->roles[Yii::app()->partner->role];
        $available_roles = ArrayHelper::map(
            Role::model()->findAllByPk(ArrayHelper::getValue($role->data, 'roles', [])),
            'Id',
            'Title'
        );

        if (empty($available_roles)){
            return $all_roles;
        }
        else{
            return array_intersect_key($all_roles, $available_roles);
        }
    }
}
