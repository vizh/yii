<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 28.05.2015
 * Time: 17:06
 */

namespace application\modules\partner\models\search;

use application\components\form\SearchFormModel;
use event\models\Event;
use user\models\User;

class Meeting extends SearchFormModel
{
    const STATUS_SENT = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_DECLINED = 2;
    const STATUS_CANCELLED_USER = 3;
    const STATUS_CANCELLED_CREATOR = 4;

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

        if ($this->Date) {
            $criteria->addCondition('"Date" = :date');
            $criteria->params[':date'] = $this->Date;
        }
        if ($this->Status != null) {
            if (in_array($this->Status, [self::STATUS_SENT, self::STATUS_ACCEPTED, self::STATUS_DECLINED, self::STATUS_CANCELLED_USER])) {
                $criteria->addColumnCondition(['"UserLinks"."Status"' => $this->Status]);
            }
            if ($this->Status == self::STATUS_CANCELLED_CREATOR) {
                $criteria->addColumnCondition(['"t"."Status"' => \connect\models\Meeting::STATUS_CANCELLED]);
            }
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
            self::STATUS_SENT => 'Отправлено',
            self::STATUS_ACCEPTED => 'Принято',
            self::STATUS_DECLINED => 'Отклонено',
            self::STATUS_CANCELLED_USER => 'Отменено приглашенным',
            self::STATUS_CANCELLED_CREATOR => 'Отменено пригласившим',
        ];
    }
}
