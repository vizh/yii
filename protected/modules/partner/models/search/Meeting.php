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

class Meeting extends SearchFormModel
{
    /** @var Event */
    private $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
        parent::__construct('');
    }

    public $Query;

    public function rules()
    {
        return [
        ];
    }

    public function attributeLabels()
    {
        return [
            'Id' => '#',
            'Creator' => 'Пригласивший',
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

        return $criteria;
    }

    public function getSort()
    {
        $sort = new \CSort();
        return $sort;

    }
}
