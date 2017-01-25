<?php
namespace application\modules\partner\models\search;

use application\components\form\SearchFormModel;
use event\models\Event;
use user\models\User;

class Competence extends SearchFormModel
{
    public $Name;

    private $event;

    public function __construct(Event $event, $scenario = '')
    {
        parent::__construct($scenario);
        $this->event = $event;
    }

    public function rules()
    {
        return [
            ['Name', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Name' => \Yii::t('app', 'Участник'),
            'Status' => \Yii::t('app', 'Статус'),
            'Finished' => \Yii::t('app', 'Пройден опрос')
        ];
    }

    /**
     * @return \CDataProvider
     */
    public function getDataProvider()
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('"Participants"."EventId" = :EventId');
        $criteria->params['EventId'] = $this->event->Id;
        $criteria->with = [
            'Participants' => [
                'together' => true,
                'return' => false
            ]
        ];
        $criteria->order = '"Participants"."CreationTime" DESC';

        $model = User::model();

        if ($this->validate()) {
            if (!empty($this->Name)) {
                $model->bySearch($this->Name, null, true, false)->byEmail($this->Name, false);
            }
        }
        $model->getDbCriteria()->mergeWith($criteria);

        return new \CActiveDataProvider($model, [
            'sort' => $this->getSort()
        ]);
    }

    /**
     * @return \CSort
     */
    private function getSort()
    {
        $sort = new \CSort();
        $sort->attributes = [
            'Name' => [
                'asc' => '"t"."LastName" ASC, "t"."FirstName" ASC',
                'desc' => '"t"."LastName" DESC, "t"."FirstName" DESC',
            ]
        ];
        $sort->defaultOrder = ['Name' => SORT_ASC];

        return $sort;
    }
}