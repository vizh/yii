<?php
namespace partner\controllers\internal;

class Icomf13addproductAction extends \partner\components\Action
{
    const EventId = 414;

    public function run()
    {
        if (\Yii::app()->partner->getAccount()->EventId != self::EventId) {
            return;
        }

        $this->processSmiAndSpeakers();
        $this->processParticipants();
    }

    protected function processSmiAndSpeakers()
    {
        $model = \event\models\Participant::model()->byEventId(self::EventId);
        $criteria = new \CDbCriteria();
        $criteria->addInCondition('t.RoleId', [2, 3]);
        /** @var $participants \event\models\Participant[] */
        $participants = $model->findAll($criteria);

        foreach ($participants as $participant) {
            $this->checkAndAddProduct($participant->UserId, 747);
        }
    }

    protected function processParticipants()
    {
        $model = \event\models\Participant::model()->byEventId(self::EventId);
        $criteria = new \CDbCriteria();
        $criteria->addInCondition('t.RoleId', [1]);
        /** @var $participants \event\models\Participant[] */
        $participants = $model->findAll($criteria);

        foreach ($participants as $participant) {
            $this->checkAndAddProduct($participant->UserId, 746);
        }
    }

    protected function checkAndAddProduct($userId, $productId)
    {
        $user = \user\models\User::model()->findByPk($userId);

        echo $user->RocId.'<br>';
        //746
    }

}
