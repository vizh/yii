<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 28.05.2015
 * Time: 17:06
 */

namespace application\modules\partner\models\search;

use application\components\form\SearchFormModel;
use connect\models\MeetingLinkUser;
use event\models\Event;
use user\models\User;

class Meeting extends SearchFormModel
{
    /** @var Event */
    private $event;

    public $Creator;
    public $UserLinks;
    public $Status;
    public $Date;

    public function __construct(Event $event)
    {
        $this->event = $event;
        parent::__construct('');
    }

    public $Query;

    public function rules()
    {
        return [
            ['Creator, UserLinks, Status, Date', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
        ];
    }


    /**
     * @return \CDataProvider
     */
    public function getDataProvider()
    {
        $sort = $this->getSort();
        $criteria = $this->getCriteria();

        return new \CActiveDataProvider('\connect\models\Meeting', [
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
        $criteria->addCondition('"Place"."EventId" = :EventId');
        $criteria->params['EventId'] = $this->event->Id;
        $criteria->with = [
            'Place',
            'Creator',
            'UserLinks',
            'UserLinks.User'
        ];
        $criteria->together = true;

        if ($this->Creator != '') {
            $users = User::model()->bySearch($this->Creator, null, true, false)->byEmail($this->Creator, false)->findAll();
            $criteria->addInCondition('"t"."CreatorId"', \CHtml::listData($users, 'Id', 'Id'));
        }

        if ($this->UserLinks != '') {
            $users = User::model()->bySearch($this->UserLinks, null, true, false)->byEmail($this->UserLinks, false)->findAll();
            $criteria->addInCondition('"UserLinks"."UserId"', \CHtml::listData($users, 'Id', 'Id'));
        }

        if ($this->Date){
            $criteria->addCondition('"Date" = :date');
            $criteria->params[':date'] = $this->Date;
        }
        if ($this->Status != null){
            $criteria->addColumnCondition(['"UserLinks"."Status"' => $this->Status]);
        }

        return $criteria;
    }

    public function getSort()
    {
        $sort = new \CSort();
        return $sort;

    }

    public function getStatusData()
    {
        return [
            MeetingLinkUser::STATUS_SENT => 'Отправлено',
            MeetingLinkUser::STATUS_ACCEPTED => 'Принято',
            MeetingLinkUser::STATUS_DECLINED => 'Отклонено',
            MeetingLinkUser::STATUS_CANCELLED => 'Отменено',
        ];
    }
}
