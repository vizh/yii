<?php
namespace ruvents\controllers\visit;

class CreateAction extends \ruvents\components\Action
{
    public function run($hallId, $visitTime, $runetId = null, $externalId = null)
    {
        $hall = \event\models\section\Hall::model()->byEventId($this->getEvent()->Id)->findByPk($hallId);
        if ($hall == null)
            throw new \ruvents\components\Exception(701, [$hallId]);

        $user = $this->getUser($runetId, $externalId);
        if ($user === null)
            throw new \ruvents\components\Exception(202, [$runetId]);

        $visitDatetime = \DateTime::createFromFormat('Y-m-d H:i:s', $visitTime);
        if ($visitDatetime === false)
            throw new \ruvents\components\Exception(702);

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

            $externalUser = \api\models\ExternalUser::model()
                ->byPartner('microsoft')->find($criteria);//todo: жестко прописано microsoft!!! переделать
            if ($externalUser === null)
                return null;

            return $externalUser->User;
        }
        return null;
    }
}
