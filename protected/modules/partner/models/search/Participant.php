<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 28.05.2015
 * Time: 17:06
 */

namespace application\modules\partner\models\search;


use application\components\form\SearchFormModel;
use event\models\Role;
use user\models\User;
use event\models\Event;

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

    public function rules()
    {
        return [
            ['Query, Role, Company', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'Name' => 'ФИО или E-mail',
            'Role' => 'Статус',
            'Company' => 'Работа',
            'Ruvents' => 'Регистрация'
        ];
    }


    /**
     * @return \CDataProvider
     */
    public function getDataProvider()
    {
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
        $criteria->addInCondition('"t"."Id"', \CHtml::listData(User::model()->findAll($this->getCriteria()), 'Id', 'Id'));

        return new \CActiveDataProvider('\user\models\User', [
            'criteria' => $criteria
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

        if ($this->validate()) {
            if ($this->Query != '') {
                $this->Query = trim($this->Query);
                if (filter_var($this->Query, FILTER_VALIDATE_EMAIL) !== false) {
                    $criteria->addCondition('"t"."Email" = :Email');
                    $criteria->params['Email'] = $this->Query;
                } else {
                    $criteria->mergeWith(User::model()->bySearch($this->Query, null, true, false)->getDbCriteria());
                }
            }

            if ($this->Role != '') {
                $criteria->addCondition('"Participants"."RoleId" = :RoleId');
                $criteria->params['RoleId'] = (int)$this->Role;
            }

            if (!empty($this->Company)) {
                $criteria->addCondition('"Company"."Name" ILIKE :Company AND "EmploymentsForCriteria"."Primary"');
                $criteria->params['Company'] = '%' . $this->Company . '%';
            }

            if (!empty($this->Ruvents)) {
                $criteria->addCondition('"BadgesForCondition"."EventId" = :EventId');
            }
        }

        //$this->fillCriteriaOrder($criteria);
        return $criteria;
    }

    /**
     * @return array
     */
    public function getRoleData()
    {
        return \CHtml::listData($this->event->getRoles(), 'Id', 'Title');
    }
}