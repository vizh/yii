<?php
namespace ruvents\controllers\visit;

use api\models\Account;
use api\models\ExternalUser;
use event\models\section\Hall;
use ruvents\components\Exception;

class CreateAction extends \ruvents\components\Action
{
    public function run($hallId, $visitTime, $runetId = null, $externalId = null)
    {
        $hall = Hall::model()
            ->byEventId($this->getEvent()->Id)
            ->byDeleted(false)
            ->findByPk($hallId);

        if ($hall === null)
            throw new Exception(701, $hallId);

        $user = $this->getUser($runetId, $externalId);

        if ($user === null)
            throw new Exception(202, $runetId);

        $visitDatetime = \DateTime::createFromFormat('Y-m-d H:i:s', $visitTime);

        if ($visitDatetime === false)
            throw new Exception(900, ['VisitTime']);

        $visit = new \event\models\section\UserVisit();
        $visit->UserId = $user->Id;
        $visit->HallId = $hall->Id;
        $visit->VisitTime = $visitDatetime->format('Y-m-d H:i:s');
        $visit->save();

        $this->renderJson(['Success' => true]);
    }

    private function getUser($runetId, $externalId)
    {
        if ($runetId !== null) {
            return \user\models\User::model()->byRunetId($runetId)->find();
        } elseif ($externalId !== null) {
            $externalId = substr($externalId, 0, 8);
            if (strlen($externalId) !== 8)
                return null;

            $criteria = new \CDbCriteria();
            $criteria->addCondition('t."ExternalId" LIKE :ExternalId');
            $criteria->params = ['ExternalId' => strtolower($externalId) . '%'];

            $externalUser = ExternalUser::model()
                ->byPartner(Account::ROLE_MICROSOFT)
                ->find($criteria);//todo: жестко прописано microsoft!!! переделать

            if ($externalUser === null)
                return null;

            return $externalUser->User;
        }

        return null;
    }
}
