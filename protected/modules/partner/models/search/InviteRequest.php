<?php
namespace partner\models\search;

use application\components\form\SearchFormModel;
use event\models\Event;
use user\models\User;

class InviteRequest extends SearchFormModel
{
    /** @var Event */
    private $event;

    public $Sender;
    public $Owner;
    public $Approved;

    public function __construct(Event $event)
    {
        $this->event = $event;
        parent::__construct('');
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['Sender,Owner', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            ['Approved', 'safe']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'Sender' => \Yii::t('app', 'Отправитель'),
            'Owner' => \Yii::t('app', 'Получатель'),
            'Approved' => \Yii::t('app', 'Статус')
        ];
    }

    /**
     *
     * @return \CDbCriteria
     */
    private function getCriteria()
    {
        $criteria = new \CDbCriteria();
        $criteria->with = ['Owner', 'Sender'];
        $criteria->addCondition('"t"."EventId" = :EventId');
        $criteria->params['EventId'] = $this->event->Id;

        if ($this->validate()) {
            if (!empty($this->Sender)) {
                $users = User::model()->bySearch($this->Sender, null, true, false)->byEmail($this->Sender, false)->findAll();
                $criteria->addInCondition('"t"."SenderUserId"', \CHtml::listData($users, 'Id', 'Id'));
            }

            if (!empty($this->Owner)) {
                $users = User::model()->bySearch($this->Owner, null, true, false)->byEmail($this->Owner, false)->findAll();
                $criteria->addInCondition('"t"."OwnerUserId"', \CHtml::listData($users, 'Id', 'Id'));
            }

            if ($this->Approved != '') {
                $criteria->addInCondition('"t"."Approved"', $this->Approved);
            }
        }
        return $criteria;
    }

    /**
     * @return \CDataProvider
     */
    public function getDataProvider()
    {
        return new \CActiveDataProvider('event\models\InviteRequest', [
            'criteria' => $this->getCriteria(),
            'sort' => $this->getSort(),
        ]);
    }

    /**
     * @return \CSort
     */
    private function getSort()
    {
        $sort = new \CSort();
        $sort->defaultOrder = ['CreationTime' => SORT_DESC];
        $sort->attributes = [
            'CreationTime',
            'Approved',
            'Sender' => [
                'asc' => '"Sender"."RunetId" ASC',
                'desc' => '"Sender"."RunetId" DESC'
            ],
            'Owner' => [
                'asc' => '"Owner"."RunetId" ASC',
                'desc' => '"Owner"."RunetId" DESC'
            ],
        ];
        return $sort;
    }
}
