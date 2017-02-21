<?php
namespace api\controllers\connect;

use application\components\CDbCriteria;
use application\components\helpers\ArrayHelper;
use connect\models\Meeting;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Sample;

class ListAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Connect",
     *     title="Список встреч",
     *     description="Списк встреч.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/connect/list?UserId=678047&RunetId=678047&CreatorId=678047'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/connect/list",
     *          body="",
     *          params={
     *              @Param(title="RunetId", description="", mandatory="N"),
     *              @Param(title="CreatorId", description="", mandatory="N"),
     *              @Param(title="UserId", description="", mandatory="N"),
     *              @Param(title="Type", description="Тип встречи. 1-закрытая,2-открытая.", mandatory="N"),
     *              @Param(title="Status", description="Сатус встречи. 1-открыта. 2-отменена.", mandatory="N")
     *          },
     *          response=@Response(body="{
                    'Success': true,
                    'Meetings': ['{$MEETING}']
                }")
     *      )
     * )
     */
    public function run()
    {
        $meetings = Meeting::model()
            ->with('UserLinks');

        if ($this->hasRequestParam('RunetId')) {
            $meetings->byCreatorId($this->getRequestedUser()->Id, false);
            $meetings->byUserId($this->getRequestedUser()->Id, false);
        }

        if ($this->hasRequestParam('CreatorId')) {
            $meetings->byCreatorId($this->getRequestedUser('CreatorId')->Id);
        }

        if ($this->hasRequestParam('UserId')) {
            $meetings->byUserId($this->getRequestedUser('UserId')->Id);
        }

        if ($this->hasRequestParam('Type')) {
            $meetings->byType($this->getRequestParam('Type'));
        }

        if ($this->hasRequestParam('Status')) {
            $meetings->byStatus($this->getRequestParam('Status'));
        }

        // Тонкость постраничной разбивки тут в том, что она не обязательна. Пока идёт ОИ16
        // нет возможности её форсировать и нужно сохранить совместимость с мобильными приложениями.
        if ($this->hasRequestParam('PageToken')) {
            $pageToken = $this->getRequestParam('PageToken');
            $pageLimit = (int)$this->getRequestParam('PageLimit', $this->getMaxResults());

            $pageCriteria = CDbCriteria::create()
                ->setOrder('"t"."Id" ASC')
                ->setOffset($pageToken === 'start' ? 0 : $this->getController()->parsePageToken($pageToken))
                ->setLimit($pageLimit)
                ->apply($meetings);
        }
        $meetings = $meetings->findAll();

        $result = [
            'Success' => true,
            'Meetings' => []
        ];

        foreach ($meetings as $meeting) {
            $result['Meetings'][] = $this
                ->getDataBuilder()
                ->createMeeting($meeting);
        }

        if (isset($pageLimit, $pageCriteria) && count($meetings) === $pageLimit) {
            $result['NextPageToken'] = $this->getController()->getPageToken($pageCriteria->offset + $pageLimit);
        }

        ArrayHelper::multisort($result['Meetings'], 'UserCount', SORT_DESC);

        $this->setResult($result);
    }
}