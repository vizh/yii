<?php
namespace api\controllers\user;

use api\components\builders\Builder;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;

class SearchAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="User",
     *     title="Поиск",
     *     description="Поиск пользователей по базе RUNET-ID.",
     *     request=@Request(
     *          method="GET",
     *          url="/user/search",
     *          body="",
     *          params={
     *              @Param(title="Query", type="Строка", defaultValue="", description="может принимать значения Email, RunetId, список RunetId через запятую, Фамилия, Фамилия Имя, Имя Фамилия")
     *          },
     *          response="{
    'Users': 'массив пользователей',
    'NextPageToken':  'указатель на следующую страницу'
}"
     *     )
     * )
     */
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $query = $request->getParam('Query', null);
        $maxResults = $request->getParam('MaxResults', $this->getMaxResults());
        $maxResults = min($maxResults, $this->getMaxResults());
        $pageToken = $request->getParam('PageToken', null);

        if (strlen($query) === 0) {
            throw new \api\components\Exception(203);
        }

        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."LastName", "t"."FirstName", "t"."RunetId"';
        if ($pageToken === null) {
            $criteria->limit = $maxResults;
            $criteria->offset = 0;
        } else {
            $criteria->limit = $maxResults;
            $criteria->offset = $this->getController()->parsePageToken($pageToken);
        }

        $with = [
            'Settings',
            'Employments.Company' => ['on' => '"Employments"."Primary"'],
        ];
        if ($this->Account->EventId != null) {
            $with['Participants'] = [
                'on' => '"Participants"."EventId" = :EventId',
                'params' => [':EventId' => $this->Account->EventId]
            ];
        } else {
            $with[] = 'Participants';
        }
        $with[] = 'Participants.Role';
        $with[] = 'Participants.Event';

        $model = \user\models\User::model();
        if (filter_var($query, FILTER_VALIDATE_EMAIL)) {
            $model->byEmail($query)->byVisible();
        } else {
            $model->bySearch($query);
        }
        $model->with($with);

        /** @var $users \user\models\User[] */
        $users = $model->findAll($criteria);

        $result = [];
        $result['Users'] = [];
        foreach ($users as $user) {
            $result['Users'][] = $this
                ->getDataBuilder()
                ->createUser($user, [
                    Builder::USER_EMPLOYMENT,
                    Builder::USER_EVENT,
                    Builder::USER_ATTRIBUTES
                ]);
        }

        if (count($users) === $maxResults) {
            $result['NextPageToken'] = $this->getController()->getPageToken($criteria->offset + $maxResults);
        }

        $this->setResult($result);
    }

}
