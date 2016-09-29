<?php
namespace api\controllers\ms;

use api\components\Action;
use api\components\builders\Builder;
use api\components\Exception;
use user\models\User;

class SearchAction extends Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $query = $request->getParam('Query', null);
        $limit = min($request->getParam('MaxResults', $this->getMaxResults()), $this->getMaxResults());
        $token = $request->getParam('PageToken', null);

        if (strlen($query) === 0) {
            throw new Exception(203);
        }

        $criteria = $this->getCriteria($limit, $token);
        $users = User::model()->bySearch($query, null, true, false)->findAll($criteria);

        $result = [
            'Users' => []
        ];

        $builder = $this->getAccount()->getDataBuilder();
        foreach ($users as $user) {
            $result['Users'][] = $builder->createUser($user, [
                Builder::USER_EMPLOYMENT,
                Builder::USER_EVENT
            ]);
        }

        if (count($user) === $limit) {
            $result['NextPageToken'] = $this->getController()->getPageToken($criteria->offset + $limit);
        }

        $this->setResult($result);
    }

    /**
     * @param int $limit
     * @param null $token
     * @return \CDbCriteria
     * @throws Exception
     */
    private function getCriteria($limit, $token = null)
    {
        $criteria = new \CDbCriteria();
        $criteria->order  = '"t"."LastName", "t"."FirstName", "t"."RunetId"';
        $criteria->limit  = $limit;
        $criteria->offset = !empty($token) ? $this->getController()->parsePageToken($token) : 0;
        $criteria->with = [
            'Settings',
            'Employments.Company' => ['on' => '"Employments"."Primary"'],
            'Participants' => [
                'together' => true,
                'on' => '"Participants"."EventId" = :EventId',
                'params' => [':EventId' => $this->getAccount()->EventId],
                'with' => ['Event', 'Role']
            ]
        ];
        $criteria->addCondition('"Participants"."Id" IS NOT NULL');
        return $criteria;
    }

}
