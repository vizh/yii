<?php

namespace api\controllers\user;

use api\components\Action;
use api\components\Exception;
use event\models\Participant;
use user\models\User;
use Yii;

class ProfessionalinterestsAction extends Action
{
    public function run()
    {
        $crtieria = new \CDbCriteria();
        $crtieria->with = ['LinkProfessionalInterests.ProfessionalInterest'];

        $runetId = Yii::app()->getRequest()->getParam('RunetId', null);
        $user = User::model()->byRunetId($runetId)->find($crtieria);
        if ($user !== null) {
            $participant = Participant::model()->byUserId($user->Id)->byEventId($this->getEvent()->Id)
                ->find();
            if ($participant === null) {
                throw new Exception(202, [$runetId]);
            }
        } else {
            throw new Exception(202, [$runetId]);
        }

        $result = [];
        foreach ($user->LinkProfessionalInterests as $link) {
            $result[] = $this->getDataBuilder()->createProfessionalInterest($link->ProfessionalInterest);
        }
        $this->setResult($result);
    }
}
