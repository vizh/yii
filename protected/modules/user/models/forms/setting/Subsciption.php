<?php
namespace user\models\forms\setting;

use user\models\UnsubscribeEventMail;

class Subsciption extends \CFormModel
{
    public $Subscribe = 1;
    public $UnsubscribeEvents = [];

    public function rules()
    {
        return [
            ['Subscribe', 'numerical'],
            ['UnsubscribeEvents', 'in', 'range' => array_keys($this->getUnsubscribeEventsData())]
        ];
    }

    public function attributeLabels()
    {
        return [
            'Subscribe' => \Yii::t('app', 'Получать рассылки системы RUNET&ndash;ID'),
            'UnsubscribeEvents' => \Yii::t('app', 'Рассылка мероприятия')
        ];
    }

    private $unsubscribeEventsData;

    /**
     * @return array|null
     */
    public function getUnsubscribeEventsData()
    {
        if ($this->unsubscribeEventsData == null) {
            $this->unsubscribeEventsData = [];
            $unsubscribes = UnsubscribeEventMail::model()->byUserId(\Yii::app()->getUser()->getCurrentUser()->Id)->findAll(['order' => '"t"."CreationTime" ASC']);
            /** @var UnsubscribeEventMail $unsubscribe */
            foreach ($unsubscribes as $unsubscribe) {
                $this->unsubscribeEventsData[$unsubscribe->EventId] = $unsubscribe->Event->Title;
            }
        }
        return $this->unsubscribeEventsData;
    }
}
