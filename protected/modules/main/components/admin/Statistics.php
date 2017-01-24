<?php
namespace main\components\admin;

use company\models\Company;
use event\models\Approved;
use event\models\Event;
use user\models\User;

class Statistics
{
    /**
     * @var UserStatisticsData
     */
    public $users;
    public $events = 0;
    public $company = 0;

    function __construct()
    {
        $this->fillEvents();
        $this->fillUsers();
        $this->fillCompany();
    }

    private function fillCompany()
    {
        $this->company = Company::model()->count();
    }

    private function fillEvents()
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('("t"."External" AND "t"."Approved" = :Approved) OR NOT "t"."External"');
        $criteria->params['Approved'] = Approved::YES;
        $this->events = Event::model()->byDeleted(false)->count($criteria);
    }

    private function fillUsers()
    {
        $this->users = new UserStatisticsData();
        $this->users->all = User::model()->count();
        $this->users->hidden = User::model()->byVisible(false)->count();

        $criteria = new \CDbCriteria();
        $criteria->with = ['Settings'];
        $criteria->addCondition('NOT "Settings"."UnsubscribeAll"');
        $this->users->subscribes = User::model()->byVisible(true)->count($criteria);
    }

}

class UserStatisticsData
{
    public $all;
    public $subscribes;
    public $hidden;
}